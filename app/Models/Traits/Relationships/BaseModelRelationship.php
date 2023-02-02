<?php

namespace App\Models\Traits\Relationships;

use App\Models\User;

trait BaseModelRelationship
{
	public function createdBy()
	{
		return $this->belongsTo(User::class, 'created_by', 'id')->withDefault();
	}

	public function updatedBy()
	{
		return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault();
	}
}
