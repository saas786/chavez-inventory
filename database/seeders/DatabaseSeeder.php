<?php

namespace Database\Seeders;

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

        $layouts = [ 'Full-size', '1800-compact', 'Tenkeyless', '75%', '60%', '40%', '20%'];
        $compTypes = [ 'Switch', 'Keycap', 'Cable', 'Plate', 'Case'];

        foreach ($layouts as  $layout) {
            DB::table('layouts')->insert([
                'name' => $layout,
            ]);
        }

        foreach ($compTypes as  $type) {
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

        \App\Models\KeyboardComponent::factory()->count( 100 )->create();

    }
}
