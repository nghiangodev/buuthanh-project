<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:32 PM.
 */

namespace App\Models\Traits\Relationships;

use App\Models\ItemCat;
use App\Models\Numberal;

trait CustomerRelationship
{
    public function itemCats()
    {
        return $this->hasMany(ItemCat::class, 'customer_id', 'id');
    }

    public function customer()
    {
        return $this->hasOne(Numberal::class, 'id', 'customer_id');
    }
}
