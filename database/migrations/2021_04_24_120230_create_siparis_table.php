<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiparisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siparis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sepet_id');
            $table->decimal('siparis_tutari');
            $table->string('durum')->nullable();
            $table->string('banka')->nullable();
            $table->string('adsoyad')->nullable();
            $table->string('adres')->nullable();
            $table->string('telefon')->nullable();
            $table->string('cepTelefonu')->nullable();

            $table->integer('taksit_sayisi')->nullable();
            $table->softDeletes();
            $table->foreign('sepet_id')->references('id')->on('sepet')->onDelete('cascade');
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
        Schema::dropIfExists('siparis');
    }
}
