<?php

namespace App\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait UserScope
{
	/**
	 * @param Builder $query
	 *
	 * @return Builder
	 */
	public function scopeHideAdmin(Builder $query)
	{
		return $query->whereKeyNot(1);
	}

	/**
	 * @param Builder $query
	 * @param $username
	 *
	 * @return Builder
	 */
	public function scopeUserOtp(Builder $query, $username)
	{
		return $query->where([
			'username' => $username,
			'use_otp'  => 1,
			'state'    => 1,
		]);
	}
}
