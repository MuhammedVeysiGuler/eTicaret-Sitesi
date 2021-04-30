<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'urun';
    protected $guarded = [];

    public function kategoriler()
    {
        return $this->belongsToMany('App\Models\Kategori', 'kategori_urun');
    }

    public function getUrunDetay()
    {
        return $this->hasOne('App\Models\UrunDetay')->withDefault();
    }
}
