<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		/** @var User $model */
		$model = $this->route('user');

		return [
			'password' => [
				'sometimes',
				'nullable',
				'confirmed',
				'min:8',
				'regex:/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/',
			],
			'email' => [
				Rule::unique('users')->ignoreModel($model, 'email')->whereNull('deleted_at'),
				'sometimes',
				'nullable',
			],
			'username' => [
				Rule::unique('users')->ignoreModel($model, 'username')->whereNull('deleted_at'),
				'string',
				'max:197',
			],
		];
	}
}
