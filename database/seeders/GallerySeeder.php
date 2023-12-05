<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('gallery');
        if ($table->count() > 1) return;

        $table->insert([
            [
                'image' => 'gallery/tanjung_pasir.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'gallery/telaga_biru.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'gallery/tebing_koja.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image' => 'gallery/al-adzhom.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
