<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = "kullanici";

    protected $fillable = [
        'adsoyad',
        'email',
        'sifre',
        'aktivasyon_anahtari',
        'aktif_mi',
    ];


    protected $hidden = [
        'sifre',
        'aktivasyon_anahtari',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
