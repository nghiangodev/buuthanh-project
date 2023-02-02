<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Models\User;

class UserService implements IBaseService
{
    public function store(array $datas)
    {
        /** @var User $user */
        $user = new User;

        //Tạo mới user
        $user->fill($datas)->save();

        //Lưu avatar
        if (isset($datas['file_avatar'])) {
            $user->saveAvatar();
        }

        //DIRECT PERMISSION && PERMISSION VIA ROLE
        $permissions = $datas['permissions'];
        $roleId      = $datas['role_id'];

        if ($permissions) {
            $user->givePermissionTo($permissions);
        }

        if ($roleId) {
            $user->assignRole(Role::find((int) $roleId));
        }

        return $user;
    }

    /**
     * @param array $datas
     * @param User $user
     *
     * @return mixed|void
     */
    public function update(array $datas, $user)
    {
        $user->fill($datas)->save();

        //Lưu avatar
        $user->saveAvatar();

        //DIRECT PERMISSION
        $permissions = $datas['permissions'];
        $user->editDirectPermission($permissions);

        //PERMISSION VIA ROLE
        $roleId = $datas['role_id'];

        if ($roleId) {
            $user->editPermissionViaRole($roleId);
        }
    }

    /**
     * @param User $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete($user)
    {
        return $user->delete();
    }
}
