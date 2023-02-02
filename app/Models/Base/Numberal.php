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
 * Class Numberal
 *
 * @property int $id
 * @property string $name
 * @property int $owner_id
 * @property int $state
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models\Base
 */
class Numberal extends Eloquent
{
	use SoftDeletes;
	protected $table = 'numberals';

	protected $casts = [
		'customer_id' => 'int',
		'state' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];
}
