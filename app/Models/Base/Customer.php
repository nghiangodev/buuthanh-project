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
 * Class Customer
 * 
 * @property int $id
 * @property string $name
 * @property string $bod
 * @property string $address
 * @property int $gender
 * @property string $phone
 * @property int $state
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models\Base
 */
class Customer extends Eloquent
{
	use SoftDeletes;
	protected $table = 'customers';

	protected $casts = [
		'gender' => 'int',
		'state' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];
}
