<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
	protected string $name = '';

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function asJson(array $params = [], $code = 200)
	{
		return response()->json($params, $code);
	}
}
