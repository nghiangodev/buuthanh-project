<?php

namespace App\Models;

use App\Enums\Gender;
use App\Models\Base\ItemCat as BaseItemCat;
use App\Models\Traits\Attributes\ItemCatAttribute;
use App\Models\Traits\Methods\ItemCatMethod;
use App\Models\Traits\Relationships\ItemCatRelationship;
use Cloudteam\BaseCore\Traits\Enumerable;

class ItemCat extends BaseItemCat
{
    use ItemCatRelationship, ItemCatAttribute,ItemCatMethod;
    use Enumerable;

    protected $fillable = [
        'full_name',
        'dob',
        'gender',
        'age',
        'customer_id',
        'numberal_id',
        'star_resolution_id',
        'state',
        'created_by',
        'updated_by',
    ];
    public static string $logName = 'Item Cat';

    protected static bool $logOnlyDirty = true;

    protected static bool $logFillable = true;

    public array $enums = [
        'gender' => Gender::class,
    ];

    public array $filters = [

    ];

    public string $displayAttribute = 'name';
}
