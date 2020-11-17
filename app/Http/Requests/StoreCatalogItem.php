<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCatalogItem extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return Auth::check();
	}

	/**
	 * Prepare the data for validation.
	 * Groups the attributes accordingly
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$keyboard = [
			"layout_id" => $this->layout_id,
			"switch_id" => $this->switch_id,
			"keycap_id" => $this->keycap_id,
			"plate_id" => $this->plate_id,
			"case_id" => $this->case_id,
		];

		$catalog_item = [
			"name" => $this->name,
			"price" => $this->price,
			"description" => $this->description,
			"image_url" => $this->image_url,
			"keyboard_id" => $this->keyboard_id,
		];

		$cable = [
			"cable_length" => $this->cable_length,
			"coil_length" => $this->coil_length,
			"color_id" => $this->color_id,
			"double_sleeved" => $this->double_sleeved == "true" ? true : false,
			"double_sleeve_color_id" =>
				$this->double_sleeve_color_id == "null"
					? null
					: $this->double_sleeve_color_id,
			"detachable" => $this->detachable == "true" ? true : false,
		];

		$this->merge([
			"keyboard" => $keyboard,
			"catalog_item" => $catalog_item,
			"cable" => $cable,
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
			"catalog_item.name" => "required",
			"catalog_item.price" => "required",
			"catalog_item.description" => "nullable",
			"catalog_item.image_url" => "nullable|image",
			"catalog_item.keyboard_id" => "nullable|integer",
			"keyboard.layout_id" => "required|integer",
			"keyboard.switch_id" => "required|integer",
			"keyboard.plate_id" => "required|integer",
			"keyboard.case_id" => "required|integer",
			"keyboard.keycap_id" => "required|integer",
			"cable.cable_length" => "required|integer",
			"cable.coil_length" => "required|integer",
			"cable.color_id" => "required|integer",
			"cable.double_sleeved" => "required|boolean",
			"cable.double_sleeve_color_id" => "nullable|integer",
			"cable.detachable" => "required|boolean",
		];
	}

	/**
	 * Configure the validator instance.
	 * After validation, store the image in Amazon S3 and store the image url
	 *
	 * @param  \Illuminate\Validation\Validator  $validator
	 * @return void
	 */
	public function withValidator($validator)
	{
		$validator->after(function () {
			$catalog_item = [
				"name" => $this->name,
				"price" => $this->price,
				"description" => $this->description,
				"image_url" =>
					$this->image_url == null
						? null
						: $this->image_url->store('images', 's3'),
			];
			$this->merge([
				'catalog_item' => $catalog_item,
			]);
		});
	}
}
