<?php

namespace App\Models\Base;

use App\Models\Traits\Methods\BaseModelMethod;
use App\Models\Traits\Relationships\BaseModelRelationship;
use App\Models\Traits\Scopes\BaseModelScope;
use Cloudteam\BaseCore\Traits\Labelable;
use Cloudteam\BaseCore\Traits\Linkable;
use Cloudteam\BaseCore\Traits\Modelable;
use Cloudteam\BaseCore\Traits\Queryable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Base\BaseModel.
 *
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
 * @property-read \App\Models\User $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel exclude($excludes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel inUse()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel include($includes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
	use Labelable, Queryable, Linkable, Modelable;
	use BaseModelScope, BaseModelMethod, BaseModelRelationship;
	use \Spatie\Activitylog\Traits\LogsActivity;

	/**
	 * Tên custom action dùng để lưu log hoạt động.
	 * @var string
	 */
	public string $logAction = '';

	/**
	 * Custom message log.
	 * @var string
	 */
	public string $logMessage = '';

	/**
	 * Column dùng để hiển thị cho model (Default là name).
	 * @var string
	 */
	public string $displayAttribute = 'name';

	/**
	 * Text hiển thị cho column.
	 * @var array
	 */
	public array $labels = [];

	/**
	 * Định nghĩa các field cho filter.
	 * @var array
	 */
	public array $filters = [];

	/**
	 * {@inheritdoc}
	 */
	public function getDescriptionForEvent(string $eventName): string
	{
		return $this->getDescriptionEvent($eventName);
	}

	protected static function boot()
	{
		parent::boot();

		self::creating(static function ($model) {
			if (auth()->check() && $model->hasAttribute('created_by')) {
				$model->created_by = auth()->id();

				if ($model->hasAttribute('updated_by')) {
					$model->updated_by = auth()->id();
				}
			}
		});

		self::updating(static function ($model) {
			if (auth()->check() && $model->hasAttribute('updated_by')) {
				$model->updated_by = auth()->id();
			}
		});
	}
}
