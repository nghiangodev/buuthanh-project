<?php
/**
 * User: ADMIN
 * Date: 21/10/2019 3:57 CH.
 */

namespace App\Models\Traits\Scopes;

use App\Enums\ActiveState;
use Illuminate\Database\Eloquent\Builder;

trait BaseModelScope
{
	public function scopeInUse(Builder $query)
	{
		return $query->where('state', ActiveState::ACTIVE);
	}
}
