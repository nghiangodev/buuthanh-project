<?php

namespace App\Models\Traits\Attributes;

use App\Enums\Communication;
use App\Enums\Confirmation;

trait UserAttribute
{
	public function getAvatarElementAttribute()
	{
		$imgPlaceholder = '<img src="' . asset('assets/images/user-placholder.png') . '" style="width: 30px; height: 30px">';

		return $this->avatar && $this->avatar_link ? '<img alt="' . __('Avatar') . '" src="' . $this->avatar_link . '" style="width: 30px; height: 30px"/>' : $imgPlaceholder;
	}

	public function getAvatarLinkAttribute()
	{
		if ($this->avatar) {
			return file_exists(storage_path('app/public/users/' . $this->avatar)) ? asset('storage/users/' . $this->avatar) : '';
		}

		return '';
	}

	public function getIsOnlineTextAttribute()
	{
		$isOnline = (int) $this->isOnline();

		try {
			return $this->contextBadgeUnified(Confirmation::getDescription($isOnline), $isOnline ? 'success' : 'danger');
		} catch (\ReflectionException $e) {
			return '';
		}
	}

	public function getIsSubscribeAttribute(): bool
	{
		return $this->subscribe === Confirmation::YES;
	}

	public function getIsSubscribeTextAttribute()
	{
		try {
			return $this->contextBadgeUnified(Confirmation::getDescription($this->subscribe), $this->is_subscribe ? 'success' : 'danger');
		} catch (\ReflectionException $e) {
			return '';
		}
	}

	public function getIsUseOtpAttribute(): bool
	{
		return $this->use_otp === Confirmation::YES;
	}

	public function getIsUseOtpTextAttribute()
	{
		try {
			return $this->contextBadgeUnified(Confirmation::getDescription($this->use_otp), $this->is_use_otp ? 'success' : 'danger');
		} catch (\ReflectionException $e) {
			logger()->error($e->getMessage());

			return;
		}
	}

	public function getOtpTypeTextAttribute(): string
	{
		$string = [];
		foreach ($this->otp_types as $otpType) {
			try {
				$string[] = Communication::getDescription((int) $otpType);
			} catch (\ReflectionException $e) {
				logger()->error($e->getMessage());

				break;
			}
		}

		return implode(', ', $string);
	}

	public function getOtpTypesAttribute(): array
	{
		return $this->otp_type ? explode(',', $this->otp_type) : [];
	}

	public function getStateTextAttribute()
	{
		return $this->contextBadgeUnified($this->state_name, $this->state === 1 ? 'success' : 'danger');
	}

	public function getSubscribeTypeTextAttribute(): string
	{
		$string = [];
		foreach ($this->subscribe_types as $otpType) {
			try {
				$string[] = Communication::getDescription((int) $otpType);
			} catch (\ReflectionException $e) {
				logger()->error($e->getMessage());

				break;
			}
		}

		return implode(', ', $string);
	}

	public function getSubscribeTypesAttribute(): array
	{
		return $this->subscribe_type ? explode(',', $this->subscribe_type) : [];
	}
}
