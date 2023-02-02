<?php

namespace App\Http\Controllers\Modules\Backend\System;

use App\Exports\UserExport;
use App\Http\Actions\ChangeModelState;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserService;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ResetPassword;
use App\Tables\System\UserTable;
use Cloudteam\BaseCore\Tables\TableFacade;
use Cloudteam\BaseCore\Utils\ModelFilter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UsersController extends Controller
{
	protected string $name = 'user';

	protected $service;

	public function __construct(UserService $userService)
	{
		parent::__construct();

		$this->middleware(['rolepermission:edit_user'], ['only' => ['changeState']]);

		$this->service = $userService;
	}

	public function changePassword(ChangeUserPasswordRequest $request, User $user): JsonResponse
	{
		$currentPassword = $request->get('current_password');
		$password        = $request->get('password');

		/** @var User $user */
		$user = $user ?? auth()->user();

		if ($user && $user->changePassword($currentPassword, $password)) {
			return $this->asJson([
				'message' => $user->label('password_changed_successfully'),
			]);
		}

		return $this->asJson([
			'message' => $user->label('the_current_password_is_not_correct'),
		], 402);
	}

	public function changeState(Request $request, ChangeModelState $action, User $user): JsonResponse
	{
		$state = $request->post('state');

		$result = $action->execute($user, $state);

		if ($result) {
			return $this->asJson([
				'message' => __('Data edited successfully'),
			]);
		}

		return $this->asJson([
			'message' => __('Data edited unsuccessfully'),
		]);
	}

	public function create()
	{
		return view('backend.modules.system.users.create', [
			'user'   => new User,
			'groups' => Role::groupRole(),
			'action' => route('users.store'),
		]);
	}

	public function destroy(User $user): JsonResponse
	{
		try {
			$this->service->delete($user);

			return $this->asJson([
				'message' => __('Data deleted successfully'),
			]);
		} catch (\Exception $e) {
			return $this->errorResponse($e);
		}
	}

	public function destroys(): JsonResponse
	{
		try {
			$ids = \request()->get('ids');
			User::destroy($ids);

			return $this->asJson([
				'message' => __('Data deleted successfully'),
			]);
		} catch (Exception $e) {
			return $this->errorResponse($e);
		}
	}

	public function edit(User $user): View
	{
		if ($user->username === 'admin') {
			abort(404);
		}

		return view('backend.modules.system.users.edit', [
			'user'        => $user,
			'action'      => route('users.update', $user),
			'roles'       => $user->roles->toArray(),
			'groups'      => Role::groupRole(),
			'permissions' => $user->getDirectPermissions()->pluck('name')->toArray(),
			'method'      => 'put',
		]);
	}

	public function exportExcel()
	{
		$filters = Cache::get('user_index_filter');

		return (new UserExport($filters))->download('list_user_' . time() . '.xlsx');
	}

	public function formChangePassword(): string
	{
		try {
			return view('backend.modules.system.users._form_change_password', ['user' => auth()->user()])->render();
		} catch (\Throwable $e) {
			return '';
		}
	}

	public function resetDefaultPassword(User $user): JsonResponse
	{
		try {
			$newPassword = md5(config('app.name') . random_int(1000, 9999));

			$user->password = Hash::make($newPassword);

			$user->setRememberToken(Str::random(60));

			$user->update();

			if ($user->email) {
				$user->notifyNow(new ResetPassword($user, $newPassword));
			}

			return response()->json([
				'message' => __('Data edited successfully'),
			]);
		} catch (\Exception $e) {
			return $this->errorResponse($e);
		}
	}

	public function index(): View
	{
		$user = new User;

		return view('backend.modules.system.users.index', [
			'user'          => $user,
			'headerConfigs' => [
				'model'     => $user,
				'createUrl' => route('users.create'),
				'buttons'   => [
					[
						'route'    => route('users.export_excel', [], false),
						'text'     => __('Export excel'),
						'icon'     => 'far fa-file-excel',
						'btnClass' => 'btn-export-excel d-none d-sm-inline-block',
						'isLink'   => true,
						'canDo'    => true,
					],
				],
			],
		]);
	}

	public function table(): string
	{
		return (new TableFacade(new UserTable))->getDataTable();
	}

	public function profile(User $user)
	{
		// @var User $user
		return view('backend.modules.system.users.profile', [
			'user'   => $user,
			'action' => route('users.update', $user),
			'method' => 'put',
		]);
	}

	/**
	 * @param User $user
	 *
	 * @return Factory|View
	 * @throws Exception
	 */
	public function show(User $user)
	{
		$logs = $user->actions;

		return view('backend.modules.system.users.show', [
			'user'        => $user,
			'logs'        => $logs,
			'groups'      => Role::groupRole(),
			'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
		]);
	}

	/**
	 * @param StoreUserRequest $request
	 *
	 * @return RedirectResponse|JsonResponse
	 *
	 * @SuppressWarnings(PHPMD)
	 * @throws Exception
	 * @throws \Throwable
	 */
	public function store(StoreUserRequest $request)
	{
		try {
			DB::beginTransaction();

			$datas = (new User)->unifySaveData($request);

			$user = $this->service->store($datas);

			DB::commit();

			return $this->redirectResponse([
				'message'      => __('Data created successfully'),
				'redirect_url' => route('users.show', $user),
			], route('users.show', $user));
		} catch (Exception $e) {
			DB::rollBack();

			return $this->errorResponse($e);
		}
	}

	/**
	 * @param UpdateUserRequest $request
	 * @param User $user
	 *
	 * @return RedirectResponse|JsonResponse
	 *
	 * @SuppressWarnings(PHPMD)
	 * @throws Exception
	 * @throws \Throwable
	 */
	public function update(UpdateUserRequest $request, User $user)
	{
		try {
			DB::beginTransaction();

			$datas = $user->unifySaveData($request);

			$this->service->update($datas, $user);

			DB::commit();

			return $this->redirectResponse([
				'message'      => __('Data edited successfully'),
				'redirect_url' => route('users.show', $user),
			], route('users.show', $user));
		} catch (Exception $e) {
			DB::rollBack();

			return $this->errorResponse($e);
		}
	}

	/**
	 * Lấy danh sách User theo dạng json.
	 */
	public function users(): JsonResponse
	{
		$modelFilter = new ModelFilter(User::query(), [
			'queryBy' => 'username',
		]);

		$users = $modelFilter->filter()
		                     ->selectRaw("id, if(name <> '' and name is not null, concat(username, ' - (', name, ')'), username) as name, name as original_name")
		                     ->hideAdmin();

		$totalCount = $users->count();
		$users      = $modelFilter->getData($users);

		return $this->asJson([
			'total_count' => $totalCount,
			'items'       => $users->toArray(),
		]);
	}
}
