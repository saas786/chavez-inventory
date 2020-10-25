<?php

namespace Database\Factories;

use App\Models\KeyboardComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyboardComponentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KeyboardComponent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'keyboard_component_type_id' => mt_rand( 1, 4 ),
            'layout_id' => mt_rand( 1, 6 ),
            'stock' => mt_rand( 0, 10 ),
            'price' => mt_rand( 0, 130000) / 100,
        ];
    }
}
