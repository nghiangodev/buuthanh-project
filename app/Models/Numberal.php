<?php

namespace App\Models;

use App\Enums\ActiveState;
use App\Enums\Gender;
use App\Models\Base\Numberal as BaseNumberal;
use App\Models\Traits\Methods\NumberalMethod;
use App\Models\Traits\Relationships\NumberalRelationship;
use Cloudteam\BaseCore\Traits\Enumerable;
use Cloudteam\BaseCore\Traits\Labelable;
use Cloudteam\BaseCore\Utils\ModelDetailable;

/**
 * App\Models\Numberal
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $owner_id
 * @property int|null $state -1: Chưa kích hoạt; 1: Đã kích hoạt
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User $createdBy
 * @property-read mixed $can_be_created
 * @property-read mixed $can_be_deleted
 * @property-read mixed $can_be_edited
 * @property-read mixed $created_at_text
 * @property-read string $model_display_text
 * @property-read string|null $model_title
 * @property-read mixed $table_name_singular
 * @property-read mixed $updated_at_text
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel exclude($excludes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel inUse()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel include ($includes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Numberal whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Numberal extends BaseNumberal
{
    use Enumerable, Labelable;
    use NumberalMethod, NumberalRelationship,ModelDetailable;

    protected $fillable = [
        'name',
        'customer_id',
        'state',
        'created_by',
        'updated_by',
    ];
    public static string $logName = 'Numberal';

    protected static bool $logOnlyDirty = true;

    protected static bool $logFillable = true;

    public array $enums = [
        'gender' => Gender::class,
        'state'  => ActiveState::class,
    ];

    public array $filters = [
        'name'             => 'like',
        'customer.address' => 'like',
        'customer.phone'   => 'like',
        'state'            => '=',
    ];

    public string $displayAttribute = 'name';
}
