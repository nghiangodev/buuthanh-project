<?php

namespace App\Models;

use App\Models\Base\Customer as BaseCustomer;
use App\Models\Traits\Methods\CustomerMethod;
use App\Models\Traits\Relationships\CustomerRelationship;
use Cloudteam\BaseCore\Utils\ModelDetailable;

class Customer extends BaseCustomer
{
    use CustomerRelationship,CustomerMethod, ModelDetailable;

    protected $fillable = [
        'name',
        'dob',
        'address',
        'gender',
        'phone',
        'state',
        'created_by',
        'updated_by',
        'updated_at',
    ];
    public static string $logName = 'Customer';

    protected static bool $logOnlyDirty = true;

    protected static bool $logFillable = true;

    public array $enums = [

    ];

    public array $filters = [

    ];

    public string $displayAttribute = 'name';
}
