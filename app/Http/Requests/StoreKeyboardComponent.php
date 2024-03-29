<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreKeyboardComponent extends FormRequest
{
	protected $errorBag = 'componentStore';

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
	 * If prices/stocks are null, then turn it into 0
	 * If the type is a keycap or switch, null the layout_id field
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
			'price' => $this->price == null ? 0 : $this->price,
			'stock' => $this->stock == null ? 0 : $this->stock,
			'layout_id' =>
				$this->keyboard_component_type_id < 3 ? null : $this->layout_id,
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
			'name' => 'required|max:255',
			'layout_id' => 'nullable|integer|min:1|max:7',
			'keyboard_component_type_id' => 'required|integer|min:1|max:4',
			'price' => 'numeric|nullable|min:0',
			'stock' => 'integer|nullable|min:0',
			'image' => 'image|nullable',
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
			$this->merge([
				'image_url' =>
					$this->image == null ? null : $this->image->store('images', 's3'),
			]);
		});
	}
}
