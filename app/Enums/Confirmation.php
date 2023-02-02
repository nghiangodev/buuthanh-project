<?php

namespace App\Enums;

/**
 * @method static static NO()
 * @method static static YES()
 */
final class Confirmation extends BaseEnum
{
	public const NO = -1;

	public const YES = 1;

	public static function getDescription($value): string
	{
		if ($value === self::NO || empty($value)) {
			return __('No');
		}

		if ($value === self::YES) {
			return __('Yes');
		}

		return parent::getDescription($value);
	}
}
