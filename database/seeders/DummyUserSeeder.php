<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
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
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@gmail.com', 'role_id' => '1', 'email_verified_at' => $date, 'password' => Hash::make('12345678'), 'reset_password_token' => 'NULL', 'reset_password_token_expire' => $date, 'remember_token' => null, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 2, 'name' => 'Shipper', 'email' => 'ship@gmail.com', 'role_id' => '3', 'email_verified_at' => $date, 'password' => Hash::make('12345678'), 'reset_password_token' => 'NULL', 'reset_password_token_expire' => $date, 'remember_token' => null, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 3, 'name' => 'DanhHa', 'email' => 'danhha221020@gmail.com', 'role_id' => '2', 'email_verified_at' => $date, 'password' => Hash::make('12345678'), 'reset_password_token' => 'NULL', 'reset_password_token_expire' => $date, 'remember_token' => null, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 4, 'name' => 'DinhThang', 'email' => 'thangdinhnguyen0102@gmail.com', 'role_id' => '2', 'email_verified_at' => $date, 'password' => Hash::make('12345678'), 'reset_password_token' => 'NULL', 'reset_password_token_expire' => $date, 'remember_token' => null, 'created_at' => $date, 'updated_at' => $date],
            ['id' => 5, 'name' => 'ThuThuong', 'email' => 'thuthuonga5@gmail.com', 'role_id' => '2', 'email_verified_at' => $date, 'password' => Hash::make('12345678'), 'reset_password_token' => 'NULL', 'reset_password_token_expire' => $date, 'remember_token' => null, 'created_at' => $date, 'updated_at' => $date],

        ];
        DB::table('users')->truncate();
        DB::table('users')->insert($dataSeeders);
    }
}
