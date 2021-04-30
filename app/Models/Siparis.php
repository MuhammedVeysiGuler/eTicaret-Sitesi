<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siparis extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'siparis';
    protected $fillable = ['adsoyad', 'adres', 'telefon', 'sepet_id', 'cepTelefonu', 'banka', 'taksit_sayisi', 'durum', 'siparis_tutari'];
    protected $guarded = ['id'];

    public function sepet()
    {
        return $this->belongsTo('App\Models\Sepet');
    }
}
