<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Cloudteam\BaseCore\Traits\Queryable;

/**
 * App\Models\ActivityLogger.
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property int|null $subject_id
 * @property string|null $subject_type
 * @property int|null $causer_id
 * @property string|null $causer_type
 * @property string|null $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User|null $causer
 * @property-read \App\Models\User $createdBy
 * @property-read mixed $can_be_created
 * @property-read mixed $can_be_deleted
 * @property-read mixed $can_be_edited
 * @property-read mixed $created_at_text
 * @property-read string $model_display_text
 * @property-read string|null $model_title
 * @property-read mixed $table_name_singular
 * @property-read mixed $updated_at_text
 * @property-read \App\Models\User $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger exclude($excludes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel inUse()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger include($includes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActivityLogger whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityLogger extends BaseModel
{
	use Queryable;

	protected $table = 'activity_logs';

	public static $logName = 'Activity log';

	public function causer()
	{
		return $this->belongsTo(User::class, 'causer_id')->withDefault();
	}

	public array $filters = [
		'description' => 'like',
		'log_name'    => '=',
		'causer_id'   => '=',
	];
}
