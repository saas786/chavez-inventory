<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class OrderCustomKeyboard extends FormRequest
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
		$keyboard = [
			'layout_id' => $this->keyboard['layout'],
			'switch_id' => Crypt::decrypt($this->keyboard['switch']),
			'keycap_id' => Crypt::decrypt($this->keyboard['keycap']),
			'case_id' => Crypt::decrypt($this->keyboard['case']),
			'plate_id' => Crypt::decrypt($this->keyboard['plate']),
		];

		$cable = $this->keyboard['cable'];

		$this->merge([
			'keyboard' => $keyboard,
			'cable' => $cable,
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
			'keyboard.layout_id' => 'required|integer',
			'keyboard.switch_id' => 'required|integer',
			'keyboard.keycap_id' => 'required|integer',
			'keyboard.plate_id' => 'required|integer',
			'keyboard.case_id' => 'required|integer',
			'cable.cable_length' => 'required|integer',
			'cable.coil_length' => 'required|integer',
			'cable.color_id' => 'required|integer',
			'cable.double_sleeved' => 'required|boolean',
			'cable.double_sleeve_color_id' => 'nullable|integer',
			'cable.detachable' => 'required|boolean',
			'customer.name' => 'required|string|max:255',
			'customer.messenger' => 'required|string|max:255',
			'customer.remarks' => 'nullable|string|max:255',
		];
		// return [
		// 	'keyboard.layout' => 'required|integer',
		// 	'keyboard.switch' => 'required|alpha_num',
		// 	'keyboard.keycap' => 'required|alpha_num',
		// 	'keyboard.plate' => 'required|alpha_num',
		// 	'keyboard.case' => 'required|alpha_num',
		// 	'keyboard.cable.cable_length' => 'required|integer',
		// 	'keyboard.cable.coil_length' => 'required|integer',
		// 	'keyboard.cable.color_id' => 'required|integer',
		// 	'keyboard.cable.double_sleeved' => 'required|boolean',
		// 	'keyboard.cable.double_sleeve_color_id' => 'nullable|integer',
		// 	'keyboard.cable.detachable' => 'required|boolean',
		// 	'customer.name' => 'required|string|max:255',
		// 	'customer.messenger' => 'required|string|max:255',
		// 	'customer.remarks' => 'nullable|string|max:255',
		// ];
	}
}
