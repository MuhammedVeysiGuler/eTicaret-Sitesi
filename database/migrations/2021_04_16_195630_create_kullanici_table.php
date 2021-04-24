<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKullaniciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullanici', function (Blueprint $table) {
            $table->id();
            $table->string('adsoyad');
            $table->string('email')->unique();
            $table->string('sifre');
            $table->string('aktivasyon_anahtari')->nullable();
            $table->boolean('aktif_mi')->default(0)->comment('0 aktif degil || 1 aktif');
            $table->boolean('yonetici_mi')->default(0)->comment('0 aktif degil || 1 aktif');;
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kullanici');
    }
}
