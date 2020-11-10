<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateColors extends FormRequest
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
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$colors = array_map(function ($color) {
			return [
				'name' => $color['name'],
				'hex_code' => $color['hexCode'],
				'primary' => $color['primary'],
				'double_sleeved' => $color['double'],
			];
		}, $this->colors);

		$this->merge([
			'colors' => $colors,
		]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'colors' => 'array|required',
			'colors.*.name' => 'string|max:255|required',
			'colors.*.hex_code' => [
				'required',
				'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/',
			],
			'colors.*.primary' => 'boolean|required',
			'colors.*.double_sleeved' => 'boolean|required',
		];
	}
}
