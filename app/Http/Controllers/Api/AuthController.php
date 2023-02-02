<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
	public function signUp(Request $request)
	{
		$request->validate([
			'username' => 'required|string',
			'password' => 'required|string|confirmed',
		]);
		$user = new User([
			'username' => $request->username,
			'password' => Hash::make($request->password),
		]);
		$user->save();

		return $this->asJson([
			'message' => 'Successfully created user!',
		], 201);
	}

	public function signIn(Request $request)
	{
		$request->validate([
			'username' => 'required|string',
			'password' => 'required|string',
			//            'remember_me' => 'boolean',
		]);

		$username = $request->get('username');
		$password = $request->get('password');

		if (Auth::attempt(['username' => $username, 'password' => $password])) {
			$user        = $request->user();
			$tokenResult = $user->createToken('Personal Access Token');
			$token       = $tokenResult->token;

			if ($request->remember_me) {
				$token->expires_at = Carbon::now()->addWeeks(1);
			}
			$token->save();

			return $this->asJson([
				'message'      => __('Success'),
				'access_token' => $tokenResult->accessToken,
				'token_type'   => 'Bearer',
				'expires_at'   => Carbon::parse(
					$tokenResult->token->expires_at
				)->toDateTimeString(),
				'user_id'  => $user->id,
				'username' => $user->username,
			]);
		}

		return $this->asJson([
			'message' => __('Login failed. Username or Password is not incorrect'),
			'datas'   => null,
		], 401);
	}

	public function signOut(Request $request)
	{
		$request->user()->token()->revoke();

		return $this->asJson([
			'message' => 'Successfully logged out',
		]);
	}

	/**
	 * Get the authenticated User.
	 *
	 * @param Request $request
	 *
	 * @return JsonResponse [json] user object
	 */
	public function getUser(Request $request)
	{
		return $this->asJson([
			'user' => $request->user(),
		]);
	}
}
