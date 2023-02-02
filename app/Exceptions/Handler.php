<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\MessageBag;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param Throwable $exception
	 *
	 * @throws Exception
	 */
	public function report(Throwable $exception)
	{
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param Request $request
	 * @param Throwable $exception
	 *
	 * @throws \Throwable
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function render($request, Throwable $exception)
	{
		if ($exception instanceof TokenMismatchException) {
			$errors = new MessageBag(['message' => __('Your session has expired. Please try again.')]);

			return redirect()
				->back()
				->withInput($request->except($this->dontFlash))
				->with(['errors' => $errors]);
		}

		//        if ($exception instanceof ValidationException) {
		//            return response()->json(['message' => __('The given data was invalid.'), 'errors' => $exception->validator->getMessageBag()], 422);
		//        }

		return parent::render($request, $exception);
	}
}
