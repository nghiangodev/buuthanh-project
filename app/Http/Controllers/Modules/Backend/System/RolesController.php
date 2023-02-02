<?php

namespace App\Http\Controllers\Modules\Backend\System;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Tables\System\RoleTable;
use Cloudteam\BaseCore\Tables\TableFacade;
use Cloudteam\BaseCore\Utils\ModelFilter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\ParameterBag;

class RolesController extends Controller
{
	protected string $name = 'role';

	public function index()
	{
		$role = new Role;

		return view('backend.modules.system.roles.index', [
			'headerConfigs' => [
				'model'     => $role,
				'caption'   => '',
				'createUrl' => route('roles.create'),
			],
			'role'          => $role,
		]);
	}

	/**
	 * Index table.
	 * @return string
	 */
	public function table()
	{
		return (new TableFacade(new RoleTable()))->getDataTable();
	}

	/**
	 * @return Factory|View
	 */
	public function create()
	{
		$groups = Role::groupRole();
		$role   = new Role;

		return view('backend.modules.system.roles.create', compact('groups', 'role'));
	}

	/**
	 * @param Role $role
	 *
	 * @return Factory|View
	 */
	public function show(Role $role)
	{
		$permissions = $role->permissions->pluck('name')->toArray();
		$groups      = Role::groupRole();

		return view('backend.modules.system.roles.show', compact('groups', 'permissions', 'role'));
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse|RedirectResponse
	 */
	public function store(Request $request)
	{
		$permissions = $request->get('permissions', []);
		$roleName    = $request->get('name');

		//note: check permission nếu chưa tồn tại thì tạo permission
		Role::checkAndCreatePermission($permissions);

		$role = Role::create(['name' => $roleName]);
		$role->givePermissionTo($permissions);

		if ($request->wantsJson()) {
			return response()->json([
				'message'      => __('Data created successfully'),
				'redirect_url' => route('roles.index'),
			]);
		}

		return redirect(route('roles.index'))->with('message', __('Data created successfully'));
	}

	public function edit(Role $role)
	{
		$permissions = $role->permissions->pluck('name')->toArray();

		$groups = Role::groupRole();

		return view('backend.modules.system.roles.edit', compact('groups', 'permissions', 'role'));
	}

	/**
	 * @param Request $request
	 * @param Role $role
	 *
	 * @return JsonResponse|RedirectResponse
	 */
	public function update(Request $request, Role $role)
	{
		$roleName           = $request->get('name');
		$permissions        = $request->get('permissions');
		$currentPermissions = $role->permissions->pluck('name');

		$removePermissions = $currentPermissions->diff($permissions);
		$newPermissions    = collect($permissions)->diff($currentPermissions);

		$role->update(['name' => $roleName]);

		//note: check permission nếu chưa tồn tại thì tạo permission
		Role::checkAndCreatePermission($permissions);

		//add new permission
		if ($newPermissions) {
			$role->givePermissionTo($newPermissions);
		}

		//remove permission
		if ($removePermissions) {
			$role->revokePermissionTo($removePermissions->toArray());
		}

		if ($request->wantsJson()) {
			return response()->json([
				'message'      => __('Data edited successfully'),
				'redirect_url' => route('roles.index'),
			]);
		}

		return redirect(route('roles.index'))->with('message', __('Data edited successfully'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Role $role
	 *
	 * @return JsonResponse
	 */
	public function destroy(Role $role)
	{
		try {
			$role->delete();
		} catch (Exception $e) {
			return response()->json([
				'message' => "Error: {$e->getMessage()}",
			], $e->getCode());
		}

		return response()->json([
			'message' => __('Data deleted successfully'),
		]);
	}

	/**
	 * Remove multiple resource from storage.
	 *
	 * @throws Exception
	 * @return mixed|ParameterBag
	 */
	public function destroys()
	{
		try {
			$ids = \request()->get('ids');
			Role::destroy($ids);
		} catch (Exception $e) {
			return response()->json([
				'message' => "Error: {$e->getMessage()}",
			], $e->getCode());
		}

		return response()->json([
			'message' => __('Data deleted successfully'),
		]);
	}

	/**
	 * @return JsonResponse
	 */
	public function roles()
	{
		$modelFilter = new ModelFilter(Role::query());

		$users = $modelFilter->filter()->select(['id', 'name']);

		$totalCount = $users->count();
		$users      = $modelFilter->getData($users);

		return $this->asJson([
			'total_count' => $totalCount,
			'items'       => $users->toArray(),
		]);
	}
}
