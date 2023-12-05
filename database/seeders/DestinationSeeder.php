<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = DB::table('destinations');
        if ($table->count() > 1) return;

        $table->insert([
            [
                'location_name' => 'Telaga Biru',
                'slug' => 'telaga_biru',
                'category' => 'alam',
                'image' => 'destination/telaga_biru.jpg',
                'address' => 'Kabupaten Tangerang, Banten, Indonesia',
                'description' => 'Telaga biru merupakan salah satu destinasi wisata alam di Tangerang, Banten. Telaga biru memiliki pemandangan yang indah dan sangat menarik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'location_name' => 'Tanjung Pasir',
                'slug' => 'tanjung_pasir',
                'category' => 'alam',
                'image' => 'destination/tanjung_pasir.jpg',
                'address' => 'Kabupaten Tangerang, Banten, Indonesia',
                'description' => 'Tanjung Pasir merupakan salah satu destinasi wisata alam (pantai) di Tangerang, Banten. Tanjung Pasir memiliki pemandangan yang indah dan sangat menarik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'location_name' => 'Tebing Koja',
                'slug' => 'tebing_koja',
                'category' => 'alam',
                'image' => 'destination/tebing_koja.jpg',
                'address' => 'Kabupaten Tangerang, Banten, Indonesia',
                'description' => 'Tebing Koja merupakan salah satu destinasi wisata alam di Tangerang, Banten. Tebing Koja memiliki pemandangan yang indah dan sangat menarik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'location_name' => 'Masjid Al-Adzhom',
                'slug' => 'masjid_al_adzhom',
                'category' => 'religi',
                'image' => 'destination/al-adzhom.jpg',
                'address' => 'Kota Tangerang, Banten, Indonesia',
                'description' => 'Masjid Al-Adzhom merupakan salah satu destinasi wisata religi di Tangerang, Banten. Masjid Al-Adzhom memiliki suasana yang nyaman dan sangat menarik. Masjid Al-Adzhom juga memiliki ruangan yang berisi buku-buku untuk dibaca para jamaah dan pengunjung.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
