<?php

/** @noinspection MessDetectorValidationInspection */

namespace App\Models;

use Carbon\Carbon;
use Cloudteam\BaseCore\Traits\Labelable;
use Cloudteam\BaseCore\Traits\Linkable;
use Cloudteam\BaseCore\Traits\Modelable;
use Cloudteam\BaseCore\Traits\Queryable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Permission;

/**
 * App\Models\Role.
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\Activity[] $activity
 * @property-read Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @method static Builder|\App\Models\Role dateBetween($fromDate, $toDate, $column = 'created_at', $format = 'd-m-Y')
 * @method static Builder|\App\Models\Role andFilterWhere($conditions)
 * @method static Builder|\Spatie\Permission\Models\Role permission($permissions)
 * @method static Builder|\App\Models\Role search($term)
 * @method static Builder|\App\Models\Role whereCreatedAt($value)
 * @method static Builder|\App\Models\Role whereGuardName($value)
 * @method static Builder|\App\Models\Role whereId($value)
 * @method static Builder|\App\Models\Role whereName($value)
 * @method static Builder|\App\Models\Role whereUpdatedAt($value)
 * @method static Builder|\App\Models\User query()
 * @mixin Eloquent
 * @SuppressWarnings(PHPMD)
 */
class Role extends \Spatie\Permission\Models\Role
{
	use Labelable, Queryable, LogsActivity, Modelable, Linkable;

	public static string $logName = 'Role';

	protected static bool $logOnlyDirty = true;

	protected static bool $logFillable = true;

	public array $filters = [
		'name' => 'like',
	];

	protected $fillable = [
		'name',
	];

	protected string $guard_name = 'web';

	/**
	 * Column dùng để hiển thị cho model (Default là name).
	 * @var string
	 */
	public string $displayAttribute = 'name';

	public static function checkAndCreatePermission($permissions)
	{
		$currentPermissions = Permission::all()->pluck('name');
		$diffPermissions    = collect($permissions)->diff($currentPermissions);

		if ($diffPermissions->isNotEmpty()) {
			$newPermissions = [];

			foreach ($diffPermissions as $diffPermission) {
				$diffs      = collect(explode('_', $diffPermission));
				$action     = $diffs->pull(0);
				$moduleName = $diffs->implode('_');

				$newPermissions[] = [
					'name'       => "{$action}_{$moduleName}",
					'guard_name' => 'web',
					'module'     => $moduleName,
					'action'     => $action,
				];
			}
			Permission::insert($newPermissions);
		}

		// Reset cached roles and permissions
		app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescriptionForEvent(string $eventName): string
	{
		return $this->getDescriptionEvent($eventName);
	}

	public static function groupRole(): array
	{
		$permissionConfigs = getPermissionConfig();

		$datas = [];

		foreach ($permissionConfigs as $key => $permissionConfig) {
			$moduleDatas = self::getRolePermission($permissionConfig['modules']);
			$datas[]     = [
				'name'    => $permissionConfig['label'] ?? __(ucfirst(camel2words($key))),
				'icon'    => $permissionConfig['icon'] ?? '',
				'modules' => $moduleDatas,
			];
		}

		return $datas;
	}

	/**
	 * @param $modules
	 *
	 * @return array
	 */
	public static function getRolePermission($modules): array
	{
		$datas = [];

		foreach ($modules as $moduleName => $module) {
			$actions         = $module['actions'];
			$permissionNames = collect($actions)->map(static function ($action) use ($moduleName) {
				return ["{$action}_{$moduleName}"];
			})->flatten()->toArray();

			$label = isset($module['label']) ? __($module['label']) : ucfirst(camel2words(Str::singular($moduleName)));

			if (! empty($module['hide'])) {
				continue;
			}

			$datas[] = [
				'name'            => __($label),
				'module'          => $module,
				'permissionNames' => $permissionNames,
				'permissions'     => $actions,
			];
		}

		return $datas;
	}
}
