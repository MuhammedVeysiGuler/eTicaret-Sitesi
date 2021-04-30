<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KullaniciDetay extends Model
{
    use HasFactory;

    protected $table = 'kullanici_detay';
    public $timestamps = false;
    protected $guarded = [];

    public function kullanici()
    {
        return $this->belongsTo('App\Models\Kullanici');
    }
}
