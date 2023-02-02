<?php

namespace App\Enums;

/**
 * @method static static MALE()
 * @method static static FEMAIL()
 */
final class Gender extends BaseEnum
{
    public const MALE = 1;

    public const FEMAIL = 2;

    public static function getDescription($value): string
    {
        if ($value === self::FEMAIL) {
            return __('Female');
        }

        if ($value === self::MALE) {
            return __('Male');
        }

        return parent::getDescription($value);
    }
}
