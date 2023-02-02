<?php

namespace App\Enums;

/**
 * @method static static EMAIL()
 * @method static static SMS()
 */
final class Communication extends BaseEnum
{
	public const EMAIL = 1;

	public const SMS = 2;
}
