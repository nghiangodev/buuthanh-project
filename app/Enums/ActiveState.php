<?php

namespace App\Enums;

/**
 * @method static static INACTIVE()
 * @method static static ACTIVE()
 */
final class ActiveState extends BaseEnum
{
	public const INACTIVE = -1;

	public const ACTIVE = 1;

	public static function getDescription($value): string
	{
		if ($value === self::ACTIVE) {
			return __('Active');
		}

		if ($value === self::INACTIVE) {
			return __('Inactive');
		}

		return parent::getDescription($value);
	}
}
