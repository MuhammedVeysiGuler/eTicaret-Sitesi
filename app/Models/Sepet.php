<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Sepet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sepet';
    protected $guarded = [];

    public function siparis()
    {
        return $this->hasOne('App\Models\Siparis');
    }

    public function sepet_urunler(){
        return $this->hasMany('App\Models\SepetUrun');
    }

    public function aktif_sepet_id()
    {
        $aktif_sepet = DB::table('sepet as s')
            ->leftJoin('siparis as si', 'si.sepet_id', '=', 's.id')
            ->where('s.kullanici_id', auth()->id())
            ->whereRaw('si.id is null')->orderByDesc('s.created_at')
            ->select('s.id')->first();
        if (!is_null($aktif_sepet)) return $aktif_sepet->id;
    }

    public function sepet_urun_adet(){
        return DB::table('sepet_urun')->where('sepet_id',$this->id)->sum('adet');
    }

    public function kullanici(){
        return $this->belongsTo('App\Models\Kullanici');
    }

}
