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
 * Class StarResolution
 *
 * @property int $id
 * @property string $name
 * @property int $state
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models\Base
 */
class StarResolution extends Eloquent
{
    use SoftDeletes;

    protected $table = 'star_resolutions';

    protected $casts = [
        'state'      => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
    ];
}
