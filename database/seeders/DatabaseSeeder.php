<?php

namespace Database\Seeders;

use App\Models\Cable;
use App\Models\Keyboard;
use App\Models\KeyboardComponent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		$layouts = [
			'Full-size',
			'1800-compact',
			'Tenkeyless',
			'75%',
			'60%',
			'40%',
			'20%',
		];
		$compTypes = ['Switch', 'Keycap', 'Plate', 'Case'];

		foreach ($layouts as $layout) {
			DB::table('layouts')->insert([
				'name' => $layout,
			]);
		}

		foreach ($compTypes as $type) {
			DB::table('keyboard_component_types')->insert([
				'name' => $type,
			]);
		}

		// \App\Models\User::factory(10)->create();
		DB::table('users')->insert([
			'name' => 'Mike',
			'email' => 'admin@admin.com',
			'password' => bcrypt('admin'),
		]);

		\App\Models\KeyboardComponent::factory()
			->count(100)
			->create();

		\App\Models\Color::factory()
			->count(20)
			->create();

		Cable::create([
			'cable_length' => 10,
			'coil_length' => 5,
			'color_id' => 1,
			'double_sleeved' => false,
		]);

		Keyboard::create([
			'layout_id' => 1,
			'switch_id' => KeyboardComponent::where(
				'keyboard_component_type_id',
				1
			)->first()->id,
			'keycap_id' => KeyboardComponent::where(
				'keyboard_component_type_id',
				2
			)->first()->id,
			'cable_id' => 1,
			'plate_id' => KeyboardComponent::where(
				'keyboard_component_type_id',
				3
			)->first()->id,
			'case_id' => KeyboardComponent::where(
				'keyboard_component_type_id',
				4
			)->first()->id,
		]);
	}
}
