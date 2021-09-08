<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyRoleSeeder extends Seeder
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
            ['id' => 1, 'name' => 'MANAGERMENT', 'order_num' => 'MANAGERMENT', 'created_at' => $date, 'updated_at' => $date, 'deleted_at' => NULL],
            ['id' => 2, 'name' => 'SALER', 'order_num' => 'SALER', 'created_at' => $date, 'updated_at' => $date, 'deleted_at' => NULL],
            ['id' => 3, 'name' => 'SHIP', 'order_num' => 'SHIP', 'created_at' => $date, 'updated_at' => $date, 'deleted_at' => NULL],
        ];
        DB::table('roles')->truncate();
        DB::table('roles')->insert($dataSeeders);
    }
}
