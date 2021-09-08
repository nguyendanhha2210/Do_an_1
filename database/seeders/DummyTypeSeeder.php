<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $dataSeeders = [
            ['id' => 2, 'type' => 'Mới Nhất', 'created_at' => $date, 'updated_at' => $date, 'deleted_at' => NULL],
        ];
        DB::table('types')->truncate();
        DB::table('types')->insert($dataSeeders);
    }
}
