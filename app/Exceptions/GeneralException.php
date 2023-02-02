<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 11:19 AM.
 */

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GeneralException extends Exception
{
	/**
	 * @var
	 */
	public $message;

	/**
	 * GeneralException constructor.
	 *
	 * @param string $message
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct($message = '', $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	/**
	 * Report the exception.
	 */
	public function report()
	{
		//
	}

	/**
	 * Render the exception into an HTTP response.
	 *
	 * @param Request
	 *
	 * @return \Illuminate\Http\RedirectResponse|Response
	 */
	public function render()
	{
		// All instances of GeneralException redirect back with a flash message to show a bootstrap alert-error
		return redirect()
			->back()
			->withInput()
			->with([
				'message' => $this->message,
				'type'    => 'danger',
			]);
	}
}
