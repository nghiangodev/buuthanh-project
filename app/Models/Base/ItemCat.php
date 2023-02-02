<?php

/**
 * Created by hieu.pham.
 * Date: {{date}}.
 */

namespace App\Models\Base;

use App\Models\Base\BaseModel as Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ItemCat
 *
 * @property int $id
 * @property int $customer_id
 * @property int $numberal_id
 * @property int $star_resolution_id
 * @property int $state
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models\Base
 */
class ItemCat extends Eloquent
{
    use SoftDeletes;

    protected $table = 'item_cats';

    protected $casts = [
        'gender'             => 'int',
        'customer_id'        => 'int',
        'numberal_id'        => 'int',
        'age'                => 'int',
        'star_resolution_id' => 'int',
        'state'              => 'int',
        'created_by'         => 'int',
        'updated_by'         => 'int',
    ];
}
