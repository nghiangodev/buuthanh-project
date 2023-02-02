<?php

namespace App\Models\Traits\Methods;

use App\Enums\ActiveState;
use Cloudteam\BaseCore\Utils\HtmlAction;
use Illuminate\Support\Facades\Schema;

trait BaseModelMethod
{
	public function generateButtonChangeStateActive($modelName)
	{
		$name = $this->{$this->displayAttribute};

		$params = [ActiveState::ACTIVE, __('Do you want to activate?'), __('Activate') . " $modelName $name", $this->getChangeStateLink(), __('Activate'), 'far fa-lock-open'];

		if ($this->state == 1) {
			$params = [ActiveState::INACTIVE, __('Do you want to deactivate?'), __('Deactivate') . " $modelName $name", $this->getChangeStateLink(), __('Deactivate'), 'far fa-lock'];
		}

		return HtmlAction::generateButtonChangeState($params);
	}

	public function generateButtonDelete($modelName)
	{
		$name = $this->{$this->displayAttribute};

		return HtmlAction::generateButtonDelete($this->getDestroyLink(), __('Delete') . " $modelName $name");
	}

	public function hasAttribute($attribute)
	{
		return Schema::hasColumn($this->getTable(), $attribute);
	}

	public function canBeSaved()
	{
		if ($this->exists) {
			return $this->can_be_edited;
		}

		return $this->can_be_created;
	}

	public function getFormTitle()
	{
		return $this->exits ? __('View and Edit') : __('Create');
	}
}
