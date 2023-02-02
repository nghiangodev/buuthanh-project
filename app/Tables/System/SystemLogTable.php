<?php

namespace App\Tables\System;

use App\Entities\Core\SystemLog;
use Cloudteam\BaseCore\Tables\DataTable;

class SystemLogTable extends DataTable
{
	public function getData(): array
	{
		$models    = $this->getModels();
		$dataArray = [];

		foreach ($models as $model) {
			$dataArray[] = [
				//                $model['context'],
				'<span class="font-weight-bold kt-badge kt-badge--inline kt-badge--rounded kt-badge--unified-' . $model['level_class'] . ' kt-badge--lg">' . $model['level'] . '</span>',
				$model['date'],
				substr($model['text'], 0, 150) . '...',
				'
				<input type="hidden" class="txt-content" value="' . str_replace('"', '\'', $model['text']) . '"/>
				<input type="hidden" class="txt-stack" value="' . str_replace('"', '\'', $model['stack']) . '"/>
				<button data-url="' . route('system_logs.view_detail') . '" class="btn-action-view btn-info" title="' . __('View') . '"><i class="far fa-eye"></i></button>
				',
			];
		}

		return $dataArray;
	}

	public function getModels()
	{
		$collection = collect(SystemLog::all());

		$this->totalRecords = $collection->count();
		$searchValue        = $this->searchValue;

		if (! empty($searchValue)) {
			$collection = $collection->filter(static function ($item) use ($searchValue) {
				return strpos($item['date'], $searchValue) !== false
					   or strpos($item['text'], $searchValue) !== false
					   or strpos($item['level'], $searchValue) !== false;
			});
		}

		if (! empty($this->filters['level'])) {
			$collection = $collection->where('level', $this->filters['level']);
		}

		$this->totalFilteredRecords = $collection->count();

		return $collection;
	}
}
