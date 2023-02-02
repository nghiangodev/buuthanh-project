<?php

/** @noinspection MessDetectorValidationInspection */

namespace App\Models;

use App\Enums\ActiveState;
use App\Enums\Communication;
use App\Enums\Confirmation;
use App\Models\Traits\Attributes\UserAttribute;
use App\Models\Traits\Methods\BaseModelMethod;
use App\Models\Traits\Methods\UserMethod;
use App\Models\Traits\Relationships\UserRelationship;
use App\Models\Traits\Scopes\UserScope;
use Cloudteam\BaseCore\Traits\Enumerable;
use Cloudteam\BaseCore\Traits\Labelable;
use Cloudteam\BaseCore\Traits\Linkable;
use Cloudteam\BaseCore\Traits\Modelable;
use Cloudteam\BaseCore\Traits\Queryable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User.
 *
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $avatar         Tên file
 * @property int $state                  -1: Chưa kích hoạt; 1: Đã kích hoạt
 * @property int|null $actor_id
 * @property string|null $actor_type
 * @property int|null $subscribe         Có nhận thông báo hay không: (-1: Không sử dụng; 1: có sử dụng)
 * @property string|null $subscribe_type Phương thức nhận thông báo: (1: Email; 2: SMS; 3:Zalo)
 * @property int|null $use_otp           Có sử dụng OTP hay không: (-1: Không sử dụng; 1: có sử dụng)
 * @property string|null $otp
 * @property string|null $otp_type       Phương thức nhận OTP: (1: Email; 2: SMS; 3:Zalo)
 * @property string|null $otp_expired_at OTP hết hạn trong 5 phút
 * @property string|null $zalo_id
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property string|null $last_login_ip
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $actions
 * @property-read int|null $actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $actor
 * @property-read mixed $avatar_element
 * @property-read mixed $avatar_link
 * @property-read mixed $can_be_created
 * @property-read mixed $can_be_deleted
 * @property-read mixed $can_be_edited
 * @property-read mixed $created_at_text
 * @property-read mixed $is_online_text
 * @property-read mixed $is_subscribe
 * @property-read mixed $is_subscribe_text
 * @property-read mixed $is_use_otp
 * @property-read mixed $is_use_otp_text
 * @property-read string $model_display_text
 * @property-read string|null $model_title
 * @property-read mixed $otp_type_text
 * @property-read mixed $otp_types
 * @property-read mixed $state_text
 * @property-read mixed $subscribe_type_text
 * @property-read mixed $subscribe_types
 * @property-read mixed $table_name_singular
 * @property-read mixed $updated_at_text
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $smallSetNotifications
 * @property-read int|null $small_set_notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User andFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User dateBetween($dates, $column = 'created_at', $format = 'd-m-Y', $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User exclude($excludes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User filters($filterDatas, $boolean = 'and', $filterConfigs = null)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User hideAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User include ($includes, $field = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User orFilterWhere($conditions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User userOtp($username)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOtpExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOtpType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSubscribeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUseOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereZaloId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, LogsActivity, CausesActivity, HasRoles, SoftDeletes, Enumerable;
    use Labelable, Queryable, Linkable, Modelable;
    use UserScope, UserMethod, UserAttribute, UserRelationship;
    use BaseModelMethod;

    public static string $logName = 'User';

    protected static array $logAttributes = ['username'];

    protected static array $ignoreChangedAttributes = ['last_login_at', 'last_login_ip', 'remember_token', 'updated_at'];

    protected static bool $logOnlyDirty = true;

    protected static bool $logFillable = true;

    /**
     * Tên custom action dùng để lưu log hoạt động.
     * @var string
     */
    public string $logAction = '';

    /**
     * Column dùng để hiển thị cho model (Default là name).
     * @var string
     */
    public string $displayAttribute = 'username';

    public array $filters = [
        'username' => 'like',
        'name'     => 'like',
        'phone'    => 'like',
        'email'    => 'like',
        'state'    => '=',
    ];

    protected $fillable = [
        'username',
        'name',
        'phone',
        'email',
        'password',
        'state',
        'use_otp',
        'otp_type',
        'subscribe',
        'subscribe_type',
        'zalo_id',
        'otp',
        'otp_expired_at',
        'actor_id',
        'actor_type',
        'last_login_at',
        'last_login_ip',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'last_login_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected array $enums = [
        'state'          => ActiveState::class,
        'communications' => Communication::class,
        'confirmations'  => Confirmation::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(static function (self $user) {
            if ($user->isDirty('state')) {
                $user->logAction = 'activated';

                if ($user->state == 0) {
                    $user->logAction = 'deactivated';
                }
            }
        });

        self::deleting(static function (self $user) {
            $user->username .= '_' . time();
        });
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'user-' . $this->id;
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->getDescriptionEvent($eventName);
    }
}
