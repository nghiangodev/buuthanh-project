<?php

namespace App\Tables\System;

use App\Models\Role;
use Cloudteam\BaseCore\Tables\DataTable;
use Cloudteam\BaseCore\Utils\HtmlAction;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RoleTable extends DataTable
{
	/**
	 * @throws Exception
	 * @return array
	 */
	public function getData(): array
	{
		$this->column = $this->getSortColumn();
		$roles        = $this->getModels();
		$dataArray    = [];
		$modelName    = lcfirst(__('Role'));

		[$canUpdateRole, $canDeleteRole] = cans(['edit_role', 'delete_role']);

		/** @var Role[] $roles */
		foreach ($roles as $role) {
			$htmlAction = $this->generateButtonAction($canDeleteRole, $modelName, $role, $canUpdateRole);

			$dataArray[] = [
				//                '<label class="kt-checkbox kt-checkbox--single kt-checkbox--brand"><input type="checkbox" value="' . $model->id . '"><span></span></label>',
				$role->name,
				$htmlAction,
			];
		}

		return $dataArray;
	}

	public function getSortColumn(): string
	{
		$column = $this->column;

		$sortColumn = 'roles.id';

		if ($column == '0') {
			$sortColumn = 'name';
		}

		return $sortColumn;
	}

	/**
	 * @return Role[]|Builder[]|Collection
	 */
	public function getModels()
	{
		$roles = Role::query()->whereKeyNot(1);

		$this->totalRecords = $this->totalFilteredRecords = $roles->count();

		if ($this->isFilterNotEmpty) {
			$roles->filters($this->filters);

			$this->totalFilteredRecords = $roles->count();
		}

		$roles = $roles->limit($this->length)->offset($this->start)
			->orderBy($this->column, $this->direction)->get();

		return $roles;
	}

	/**
	 * @param bool $canDeleteRole
	 * @param string $modelName
	 * @param Role $role
	 * @param bool $canUpdateRole
	 *
	 * @return string
	 */
	protected function generateButtonAction($canDeleteRole, $modelName, $role, $canUpdateRole): string
	{
		$buttonEdit = $buttonDelete = '';

		if ($canDeleteRole) {
			$buttonDelete = HtmlAction::generateButtonDelete($role->getDestroyLink(), __('Delete') . " $modelName $role->name");
		}

		if ($canUpdateRole) {
			$buttonEdit = HtmlAction::generateButtonEdit($role->getEditLink());
		}
		$buttonView = HtmlAction::generateButtonView($role->getViewLink());

		return $buttonView . $buttonEdit . $buttonDelete;
	}
}
