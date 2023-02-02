<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:32 PM.
 */

namespace App\Models\Traits\Relationships;

use App\Models\Customer;
use App\Models\ItemCat;
use Illuminate\Notifications\DatabaseNotification;

trait NumberalRelationship
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id')->withDefault();
    }

    public function itemCats()
    {
        return $this->hasMany(ItemCat::class, 'numberal_id', 'id');
    }
}
