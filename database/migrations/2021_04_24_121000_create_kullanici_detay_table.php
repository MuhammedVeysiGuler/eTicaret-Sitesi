<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKullaniciDetayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullanici_detay', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kullanici_id');
            $table->string('adres')->nullable();
            $table->string('telefon')->nullable();
            $table->string('cepTelefonu')->nullable();
            $table->foreign('kullanici_id')->references('id')->on('kullanici')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kullanici_detay');
    }
}
