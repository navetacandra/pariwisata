<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('users');
        if($table->count() > 1) return;

        $table->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin12345678'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
