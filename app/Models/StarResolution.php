<?php

namespace App\Models;

use App\Models\Base\StarResolution as BaseStarResolution;
use App\Models\Traits\Methods\StarResolutionMethod;

class StarResolution extends BaseStarResolution
{
    use StarResolutionMethod;
    protected $fillable = [
        'name',
        'state',
        'created_by',
        'updated_by',
    ];
    public static string $logName = 'Star Resolution';

    protected static bool $logOnlyDirty = true;

    protected static bool $logFillable = true;

    public array $enums = [

    ];

    public array $filters = [

    ];

    public string $displayAttribute = 'name';
}
