<?php

namespace Database\Seeders;

use App\Models\Urun;
use App\Models\UrunDetay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker;

class UrunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {

        for ($i = 0; $i < 30; $i++) {
            $urun = Urun::create([
                'urun_adi' => $faker->name,
                'slug' => $faker->slug,
                'aciklama' => $faker->sentence(10),
                'fiyat' => $faker->randomFloat(3, 1, 20)
            ]);

            $detay = $urun->getUrunDetay()->create([
                'goster_slider' => rand(0, 1),
                'goster_gunun_firsati' => rand(0, 1),
                'goster_one_cikan' => rand(0, 1),
                'goster_cok_satan' => rand(0, 1),
                'goster_indirimli' => rand(0, 1),
            ]);
        }
    }
}
