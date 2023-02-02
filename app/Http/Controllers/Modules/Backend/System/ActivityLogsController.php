<?php

namespace App\Http\Controllers\Modules\Backend\System;

use App\Exports\ActivityLogExport;
use App\Http\Controllers\Controller;
use App\Models\ActivityLogger;
use App\Tables\System\ActivityLogTable;
use Cloudteam\BaseCore\Tables\TableFacade;
use Illuminate\Support\Facades\Cache;

class ActivityLogsController extends Controller
{
	protected string $name = 'log';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$logNames = ActivityLogger::select('log_name')->groupBy('log_name')->get()->toArray();

		return view('backend.modules.system.activity_logs.index', [
			'logNames'      => $logNames,
			'activityLog'   => new ActivityLogger(),
			'headerConfigs' => [
				'model'     => new ActivityLogger(),
				'modelName' => __('Activity log'),
				'createUrl' => null,
				'buttons'   => [],
			],
		]);
	}

	/**
	 * @return string
	 */
	public function table()
	{
		return (new TableFacade(new ActivityLogTable()))->getDataTable();
	}

	public function viewDetail(ActivityLogger $activityLog)
	{
		return view('backend.modules.system.activity_logs.activity_log_detail', ['log' => $activityLog]);
	}

	public function getMoreLogs()
	{
		$page = request()->get('page', 1);

		$logs = ActivityLogger::query()->latest()->offset($page * 10)->limit(10)->get(['description', 'created_at']);

		return response()->json([
			'datas'   => $logs,
			'isEmpty' => $logs->isEmpty(),
		]);
	}

	public function exportExcel()
	{
		$filters = Cache::get('log_index_filter');

		return (new ActivityLogExport($filters))->download('log_' . time() . '.xlsx');
	}
}
