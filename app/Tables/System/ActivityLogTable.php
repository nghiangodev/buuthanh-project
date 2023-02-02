<?php

namespace App\Tables\System;

use App\Models\ActivityLogger;
use Cloudteam\BaseCore\Tables\DataTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ActivityLogTable extends DataTable
{
	public function getData(): array
	{
		$this->column = $this->getSortColumn();
		$models       = $this->getModels();
		$dataArray    = [];

		/** @var ActivityLogger[] $models */
		foreach ($models as $model) {
			$routeViewDetail = route('activity_logs.view_detail', $model);

			$dataArray[] = [
				$model->log_name === 'Auth' ? 'Auth' : __($model->log_name),
				optional($model->causer)->username,
				"<span title='" . $model->description . "'>" . Str::limit($model->description, 50) . '</span>',
				optional($model->created_at)->format('d-m-Y H:i:s'),
				'<a href="javascript:void(0)" data-url="' . $routeViewDetail . '" class="btn-action-view btn-info" title="' . __('View') . '">
					<i class="far fa-eye"></i>
				</a>',
			];
		}

		return $dataArray;
	}

	public function getSortColumn(): string
	{
		$column = $this->column;

		switch ($column) {
			case '1':
				$column = 'activity_logs.causer_id';
				break;
			case '2':
				$column = 'activity_logs.description';
				break;
			case '3':
				$column = 'activity_logs.created_at';
				break;
			default:
				$column = 'activity_logs.id';
				break;
		}

		return $column;
	}

	/**
	 * @return ActivityLogger[]|Builder[]|Collection
	 */
	public function getModels()
	{
		$logs = ActivityLogger::query()->with('causer');

		$this->totalRecords = $this->totalFilteredRecords = $logs->count();

		if ($this->isFilterNotEmpty) {
			$logs->filters($this->filters);

			$fromDate = $this->filters['from_date'];
			$toDate   = $this->filters['to_date'];

			if ($fromDate) {
				$logs->dateBetween([$fromDate, $toDate]);
			}

			$logs->filters($this->filters);

			$this->totalFilteredRecords = $logs->count();
		}

		return $logs->limit($this->length)->offset($this->start)->orderBy($this->column, $this->direction)->get();
	}
}
