<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:26 PM.
 */

namespace App\Models\Traits\Methods;

use App\Enums\ActiveState;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

trait UserMethod
{
	/**
	 * Check tài khoản có được active hay không.
	 * @return bool
	 */
	public function isActive(): bool
	{
		return $this->state == ActiveState::ACTIVE;
	}

	/**
	 * Check tài khoản có phải admin hay không.
	 * @return bool
	 */
	public function isAdmin(): bool
	{
		return $this->username === 'admin';
	}

	public function getChangeStateLink()
	{
		return route('users.change_state', $this, false);
	}

	public function unifySaveData($request)
	{
		$datas = $request->all();

		$this->password = $this->getOriginal('password');
		$newPassword    = $request->input('password');

		$datas['password'] = $this->password;

		if ($newPassword) {
			$datas['password'] = Hash::make($newPassword);
		}

		$datas['file_avatar'] = $request->hasFile('file_avatar') ? $request->file('file_avatar') : null;
		$datas['permissions'] = $request->input('permissions', []);
		$datas['role_id']     = $request->input('role_id', '');

		return $datas;
	}

	public function editDirectPermission($permissions)
	{
		$user               = $this;
		$currentPermissions = $user->permissions->pluck('name');
		$removePermissions  = $currentPermissions->diff($permissions);
		$newPermissions     = collect($permissions)->diff($currentPermissions);

		//add new permission
		if ($newPermissions->isNotEmpty()) {
			$user->givePermissionTo($newPermissions);
		}

		//remove permission
		if ($removePermissions->isNotEmpty()) {
			$user->revokePermissionTo($removePermissions->toArray());
		}
	}

	public function editPermissionViaRole($roleId)
	{
		$user        = $this;
		$currentRole = $user->roles->first();

		if ( ! $currentRole || $currentRole->id != $roleId) {
			//Xóa role hien tai di
			if ($currentRole) {
				$user->removeRole($currentRole->id);
			}

			$role = Role::find((int) $roleId);

			if ( ! $user->hasRole($role)) {
				$user->assignRole($role);
			}
		}
	}

	public function saveOtpType($requestData)
	{
		$requestData['otp_type'] = null;

		if ($requestData['use_otp'] == 1) {
			$otpTypes = $requestData['otp_type'];

			$otpTypeText             = $otpTypes ? implode(',', $otpTypes) : '';
			$requestData['otp_type'] = $otpTypeText;
		}
	}

	public function saveSubscribeType($requestData)
	{
		$requestData['subscribe_type'] = null;

		if ($requestData['subscribe'] == 1) {
			$subscribeTypes = $requestData['subscribe_type'];

			$subscribeTypeText             = $subscribeTypes ? implode(',', $subscribeTypes) : '';
			$requestData['subscribe_type'] = $subscribeTypeText;
		}
	}

	public function saveAvatar()
	{
		/** @var UploadedFile $image */
		$image = request()->file('file_avatar');

		if (! $image) {
			return $this->update([
				'avatar' => null,
			]);
		}

		$filename = $image->getClientOriginalName();

		//note: Kiểm tra file co thay doi hay không
		if ($this->avatar !== $filename) {
			$extension    = $image->getClientOriginalExtension();
			$fileFullName = md5($filename) . ".$extension";

			$image->move(storage_path('app/public/users'), $fileFullName);

			return $this->update([
				'avatar' => $fileFullName,
			]);
		}
	}

	public function changePassword($currentPassword, $newPassword)
	{
		if (Hash::check($currentPassword, $this->password)) {
			return $this->update([
				'password' => Hash::make($newPassword),
			]);
		}

		return false;
	}

}
