<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_levels')->insert([
            'name' => '1er nivel',
            'detail' => 'Descripcion del 1er nivel',
        ]);
    }
}
