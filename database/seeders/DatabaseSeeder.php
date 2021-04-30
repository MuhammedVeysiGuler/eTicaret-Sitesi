<?php

namespace Database\Seeders;

use App\Http\Controllers\KategoriController;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            KategoriSeeder::class,
            UrunSeeder::class,
            KullaniciSeeder::class,
        ]);
    }
}
