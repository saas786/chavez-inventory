<?php

namespace Database\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColorFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Color::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->colorName,
			'hex_code' => $this->faker->hexColor,
			'primary' => mt_rand(0, 1) == 1 ? true : false,
			'double_sleeved' => mt_rand(0, 1) == 1 ? true : false,
		];
	}
}
