<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Core\Otp;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function credentials(Request $request)
	{
		return [
			$this->username() => $request->get('username'),
			'password'        => $request->password,
			'state'           => 1,
		];
	}

	/**
	 * @return string
	 */
	public function username()
	{
		$login = request()->get('username');

		return filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
	}

	/**
	 * {@inheritdoc}
	 * @throws Exception
	 */
	public function login(Request $request)
	{
		$this->validateLogin($request);

		if ($this->hasTooManyLoginAttempts($request)) {
			$this->fireLockoutEvent($request);

			$this->sendLockoutResponse($request);
		}

		if (env('LOGIN_OTP', false)) {
			$username = $request->get('username');
			$user     = User::query()->userOtp($username)->first();

			if ($user && Auth::once($this->credentials($request))) {
				$otp = new Otp($username, $user);

				$responseText = $otp->getResponseText();

				if (! $otp->send()) {
					throw ValidationException::withMessages([
						'otp_error' => __('auth.Something wrong, please try again later'),
					]);
				}

				session(['password' => $request->password, 'responseText' => $responseText, 'username' => $username]);

				return response()->redirectToRoute('otp');
			}
		}

		if ($this->attemptLogin($request)) {
			return $this->sendLoginResponse($request);
		}

		$this->incrementLoginAttempts($request);

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * @param Request $request
	 *
	 * @throws Exception
	 * @return \Illuminate\Http\Response|Response
	 */
	public function loginOtp(Request $request)
	{
		$otpText  = $request->get('otp');
		$username = session('username', '');
		$password = session('password');

		$otp = new Otp($username);

		if (! $otp->validate($otpText)) {
			throw ValidationException::withMessages([
				'otp' => __('auth.OTP is not valid'),
			]);
		}

		$credentials             = $this->credentials($request);
		$credentials['password'] = $password;
		$credentials['username'] = $username;

		if ($this->guard()->attempt($credentials)) {
			$otp->reset();

			//note: Xóa password trong session sau khi login OTP thành công
			session()->remove('password');

			return $this->sendLoginResponse($request);
		}

		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * @throws Exception
	 * @return JsonResponse
	 */
	public function resendOtp()
	{
		$username = session('username', '');

		$user = User::query()->userOtp($username)->first();

		$otp = new Otp($username, $user);

		if (! $otp->send()) {
			return response()->json([
				'message' => __('auth.Something wrong, please try again later'),
			], 500);
		}

		return response()->json([
			'message' => $otp->getResponseText(),
		]);
	}

	/**
	 * @return Factory|View
	 */
	public function formOtp()
	{
		$responseText = session('responseText', '');

		return view('auth.otp', compact('responseText'));
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return JsonResponse|RedirectResponse
	 */
	protected function sendFailedLoginResponse(Request $request)
	{
		$errors = [$this->username() => trans('auth.failed')];
		$user   = User::where($this->username(), $request->{$this->username()})->first();

		if (! $user) {
			$errors = [$this->username() => trans('auth.User not found')];
		} elseif (! Hash::check($request->password, $user->password)) {
			$errors = ['password' => trans('auth.Wrong password')];
		}

		if ($request->expectsJson()) {
			return response()->json($errors, 422);
		}

		return redirect()->back()
			->withInput($request->only($this->username(), 'remember'))
			->withErrors($errors);
	}
}
