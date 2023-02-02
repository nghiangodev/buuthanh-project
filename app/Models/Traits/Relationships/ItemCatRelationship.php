<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:32 PM.
 */

namespace App\Models\Traits\Relationships;

use App\Models\StarResolution;

trait ItemCatRelationship
{
    public function starResolution()
    {
        return $this->belongsTo(StarResolution::class, 'star_resolution_id', 'id');
    }
}
