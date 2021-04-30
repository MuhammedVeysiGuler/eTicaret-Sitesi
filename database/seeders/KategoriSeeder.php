<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori');
        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Kadin', 'slug' => 'kadin']);
        DB::table('kategori')->insert(['kategori_adi' => 'Giyim', 'slug' => 'giyim', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Aksesuar', 'slug' => 'aksesuar', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Kozmetik', 'slug' => 'kozmetik', 'ust_id' => $id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Erkek', 'slug' => 'erkek']);
        DB::table('kategori')->insert(['kategori_adi' => 'Giyim', 'slug' => 'giyim', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Ayakkabi', 'slug' => 'ayakkabi', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Kisisel Bakim', 'slug' => 'kisisel-bakim', 'ust_id' => $id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Cocuk', 'slug' => 'cocuk']);
        DB::table('kategori')->insert(['kategori_adi' => 'Bebek', 'slug' => 'bebek', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Kiz Cocuk', 'slug' => 'kiz-cocuk', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Erkek Cocuk', 'slug' => 'erkek-cocuk', 'ust_id' => $id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Ev&Yasam', 'slug' => 'ev-yasam']);
        DB::table('kategori')->insert(['kategori_adi' => 'Sofra&Mutfak', 'slug' => 'sofra-mutfak', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Dekorasyon', 'slug' => 'dekorasyon', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Hobi', 'slug' => 'hobi', 'ust_id' => $id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Supermarket', 'slug' => 'supermarket']);
        DB::table('kategori')->insert(['kategori_adi' => 'Ev&Temizlik', 'slug' => 'ev-temizlik', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Gida', 'slug' => 'gida', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Petshop', 'slug' => 'petshop', 'ust_id' => $id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Kozmetik', 'slug' => 'kozmetik']);
        DB::table('kategori')->insert(['kategori_adi' => 'Makyaj', 'slug' => 'makyaj', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Parfum&Deodorant', 'slug' => 'parfum-deodorant', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Cilt Bakimi', 'slug' => 'cilt-bakimi', 'ust_id' => $id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Ayakkabi&Canta', 'slug' => 'ayakkabi-canta']);
        DB::table('kategori')->insert(['kategori_adi' => 'Kadın Ayakkabi', 'slug' => 'kadin-ayakkabi', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Erkek Ayakkabi', 'slug' => 'erkek-ayakkabi', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Cocuk Ayakkabi', 'slug' => 'cocuk-ayakkabi', 'ust_id' => $id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi' => 'Elektronik', 'slug' => 'elektronik']);
        DB::table('kategori')->insert(['kategori_adi' => 'Kucuk Ev Aletleri', 'slug' => 'kucuk-ev-aletleri', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Bilgisayar&Tablet', 'slug' => 'bilgisayar-tablet', 'ust_id' => $id]);
        DB::table('kategori')->insert(['kategori_adi' => 'Beyaz Esya', 'slug' => 'beyaz-esya', 'ust_id' => $id]);

    }
}
