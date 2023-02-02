<?php
/**
 * User: ADMIN
 * Date: 5/9/2019 5:32 PM.
 */

namespace App\Models\Traits\Relationships;

use Illuminate\Notifications\DatabaseNotification;

trait UserRelationship
{
	public function actor()
	{
		return $this->morphTo();
	}

	/**
	 * Get the entity's notifications.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function smallSetNotifications()
	{
		return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc')->offset(0)->limit(100);
	}
}
