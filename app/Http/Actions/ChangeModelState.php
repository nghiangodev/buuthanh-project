<?php

namespace App\Http\Actions;

class ChangeModelState
{
	public function execute($model, $state)
	{
		return $state && $model->update(['state' => $state]);
	}
}
