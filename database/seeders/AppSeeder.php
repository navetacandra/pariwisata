<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('app');
        if ($table->count() > 1) return;

        $table->insert([
            'name' => 'Pariwisata',
            'logo' => 'app/logo.png',
            'about' => 'Kabupaten Tangerang merupakan salah satau kabupaten di wilayah provinsi Banten yang memiliki banyak tempat wisata yang menarik',
            'address' => 'Kabupaten Tangerang, Banten, Indonesia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
