<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class OrderPrebuiltKeyboard extends FormRequest
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
		$this->merge([
			'tracking_id' => Str::random(15),
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
			'customer_name' => 'string|max:255|required',
			'messenger_name' => 'string|max:255|required',
			'prebuilt_order_id' => 'integer|exists:prebuilt_orders,id',
			'tracking_id' => 'required|max:15|min:15',
		];
	}
}
