<?php

namespace App\Tables\System;

use App\Enums\ActiveState;
use App\Models\Role;
use App\Models\User;
use Cloudteam\BaseCore\Tables\DataTable;
use Cloudteam\BaseCore\Utils\HtmlAction;
use Exception;
use Illuminate\Support\Facades\Cache;

class UserTable extends DataTable
{
    /**
     * @return array
     * @throws Exception
     */
    public function getData(): array
    {
        $this->column = $this->getSortColumn();
        $users        = $this->getModels();
        $dataArray    = [];
        $modelName    = lcfirst(__('User'));

        [$canUpdateUser, $canDeleteUser, $canApproveUser] = cans(['edit_user', 'delete_user', 'approve_user']);

        /** @var User[] $users */
        foreach ($users as $key => $user) {
            $htmlAction = $this->generateButton($modelName, $user, [$canUpdateUser, $canDeleteUser, $canApproveUser]);

            $dataArray[] = [
                //				'<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand"><input data-index="'.$user->id.'" type="checkbox" value="'.$user->id.'"><span></span></label>',
                ++$key + $this->start,
                $user->username,
                $user->name,
                $user->phone,
                $user->email,
                $user->role_name,
                $user->state_text,
                optional($user->last_login_at)->format('d-m-Y H:i:s'),
                $htmlAction,
            ];
        }

        return $dataArray;
    }

    public function getSortColumn(): string
    {
        $column  = $this->column;
        $columns = ['users.id', 'username', 'name', 'phone', 'email', 'state', 'last_login_at'];

        return $columns[$column];
    }

    public function getModels()
    {
        $users = User::query()->hideAdmin()->whereKeyNot(auth()->id());

        $this->totalFilteredRecords = $this->totalRecords = $users->count();

        $users->with(['actor'])->leftJoin('model_has_roles as mhr', 'mhr.model_id', '=', 'users.id')
              ->addSelect(['role_name' => Role::select('name')->whereColumn('id', 'mhr.role_id')]);

        if ($this->isFilterNotEmpty) {
            // note: filter role trước, nếu để sau filters sẽ tìm role bị sai

            if (isset($this->filters['role_id']) && filled($this->filters['role_id'])) {
                $roleIds = $this->filters['role_id'];
                $users->role($roleIds);
            }

            $users->filters($this->filters);

            $this->totalFilteredRecords = $users->count();
        }

        Cache::put('user_index_filter', $this->filters, now()->addMinutes(10));

        return $users->limit($this->length)
                     ->offset($this->start)
                     ->orderBy($this->column, $this->direction)->get();
    }

    private function generateButton(string $modelName, User $user, array $permissions): string
    {
        [$canEditUser, $canDeleteUser, $canApproveUser] = $permissions;

        $buttonChangeState = $buttonResetPassword = $buttonEdit = $buttonDelete = '';

        if ($canApproveUser) {
            $params = [
                ActiveState::ACTIVE,
                __('Do you want to activate?'),
                __('Activate') . " $modelName $user->username",
                $user->getChangeStateLink(),
                __('Activate'),
                'far fa-user-check',
            ];

            if ($user->state == 1) {
                $params = [
                    ActiveState::INACTIVE,
                    __('Do you want to deactivate?'),
                    __('Deactivate') . " $modelName $user->username",
                    $user->getChangeStateLink(),
                    __('Deactivate'),
                    'far fa-user-lock',
                ];
            }

            $buttonChangeState = HtmlAction::generateButtonChangeState($params);
        }

        if ($canEditUser) {
            $buttonEdit = HtmlAction::generateButtonEdit($user->getEditLink());

            if ($user->email) {
                $buttonResetPassword = HtmlAction::generateCustomButton(
                    [
                        'btn-blue-500 btn-reset-default-password',
                        __('Reset password') . " $modelName $user->username",
                        route('users.reset_default_password', $user, false),
                        __('Reset password'),
                        'far fa-key',
                    ]
                );
            }
        }

        if ($canDeleteUser) {
            $buttonDelete = HtmlAction::generateButtonDelete($user->getDestroyLink(), __('Delete') . " $modelName $user->username");
        }

        //        $buttonView = HtmlAction::generateButtonView($user->getViewLink());

        return $buttonResetPassword . $buttonChangeState . $buttonEdit . $buttonDelete;
    }
}
