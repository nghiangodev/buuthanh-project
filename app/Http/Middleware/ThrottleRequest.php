<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 8/16/2018
 * Time: 4:38 PM.
 */

namespace App\Http\Middleware;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ThrottleRequest extends ThrottleRequests
{
	protected function buildException($key, $maxAttempts)
	{
		$retryAfter = $this->getTimeUntilNextRetry($key);

		$headers = $this->getHeaders(
			$maxAttempts,
			$this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
			$retryAfter
		);

		return new ThrottleRequestsException(__('Too many resend OTP attempts. Please retry again after 5 minutes.'), null, $headers);
	}
}
