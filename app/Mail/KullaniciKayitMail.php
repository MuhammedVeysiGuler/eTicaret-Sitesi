<?php

namespace App\Mail;

use App\Models\Kullanici;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KullaniciKayitMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; //tanımlanan bu değişken view içerisinde kullanılbilir.  mails.kullanici_kayit

    public function __construct(Kullanici $user )
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name').(' Kullanıcı Kaydı'))
            ->view('mails.kullanici_kayit');
    }
}
