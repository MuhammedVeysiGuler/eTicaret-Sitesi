<?php

namespace Database\Seeders;

use App\Models\Kullanici;
use App\Models\KullaniciDetay;
use Illuminate\Database\Seeder;
use Faker\Generator;

class KullaniciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $kullanici_yonetici = Kullanici::create([
            'adsoyad' => 'BabaSultan',
            'email' => 'babasultan@gmail.com',
            'sifre' => bcrypt('123456'),
            'aktif_mi' => 1,
            'yonetici_mi' => 1
        ]);
        $kullanici_yonetici->detay()->create([
            'adres' => 'Elazığ',
            'telefon' => '(023) 111 11 11',
            'cepTelefonu' => '(023) 222 22 22',
        ]);

        for ($i = 0; $i < 50; $i++) {
            $kullanici_musteri = Kullanici::create([
                'adsoyad' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'sifre' => bcrypt('123456'),
                'aktif_mi' => 1,
                'yonetici_mi' => 0
            ]);
            $kullanici_musteri->detay()->create([
                'adres' => $faker->address,
                'telefon' => $faker->phoneNumber,
                'cepTelefonu' => $faker->phoneNumber,
            ]);
        }
    }
}
