<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected string $name = '';

	public function __construct()
	{
		$this->middleware(['auth', 'active']);
		$this->middleware(['rolepermission:view_' . $this->name], ['only' => ['index', 'show']]);
		$this->middleware(['rolepermission:create_' . $this->name], ['only' => ['create', 'store']]);
		$this->middleware(['rolepermission:delete_' . $this->name], ['only' => ['destroy']]);

		$this->middleware(['rolepermission:edit_' . $this->name], ['only' => ['update']]);
		$this->middleware(["rolepermission:edit_{$this->name}|view_{$this->name}"], ['only' => ['edit']]);
	}

	protected function asJson(array $params = [], $code = 200)
	{
		return response()->json($params, $code);
	}

	/**
	 * @param $params
	 * @param string $url
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	protected function redirectResponse($params, $url = '')
	{
		if (request()->wantsJson()) {
			return $this->asJson($params);
		}

		return redirect($url)->with($params);
	}

	protected function errorResponse(\Exception $exception) : JsonResponse
	{
		Log::error("{$exception->getMessage()} - {$exception->getFile()}} - {$exception->getLine()}");

		if (request()->wantsJson()) {
			return $this->asJson([
				'message' => "{$exception->getMessage()} - {$exception->getFile()}} - {$exception->getLine()}",
			], 500);
		}
	}
}
