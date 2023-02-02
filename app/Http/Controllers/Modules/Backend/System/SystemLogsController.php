<?php

namespace App\Http\Controllers\Modules\Backend\System;

use App\Http\Controllers\Controller;
use App\Tables\System\SystemLogTable;
use Cloudteam\BaseCore\Tables\TableFacade;
use Illuminate\Http\Response;

class SystemLogsController extends Controller
{
	protected string $name = 'log';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('backend.modules.system.system_logs.index');
	}

	/**
	 * @return string
	 */
	public function table()
	{
		return (new TableFacade(new SystemLogTable()))->getDataTable();
	}

	public function viewDetail()
	{
		$content = request()->get('content');
		$stack   = request()->get('stack');

		return view('backend.modules.system.system_logs._detail', compact('content', 'stack'));
	}
}
