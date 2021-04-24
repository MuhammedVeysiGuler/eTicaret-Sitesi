<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use   Auth;

class KullaniciController extends Controller
{
    public function index(){
        return 'adasdasd';
    }

    public function oturumac(){
        if (\request()->isMethod('POST')){
            $this->validate(\request(),[
                'email' => 'required|email',
                'sifre' => 'required'
            ]);
            $credentials = [
                'email' => \request()->get('email'),
                'password' => \request()->get('sifre'),
                'yonetici_mi' => 1
            ];
            if (Auth::guard('yonetim')->attempt($credentials,\request()->has('benihatirla'))){
                return redirect()->route('yonetim.anasayfa');
            }else{
                return back()->withInput()->withErrors(['email'=>'Giriş Hatalı']);
            }
        }
        return view('yonetim.oturumac');
    }

    public function oturumuKapat(){
        Auth::guard('yonetim')->logout();
        \request()->session()->flush(); //sessiondaki bilgileri sıfırlamak için kullanılır
        \request()->session()->regenerate();
        return redirect()->route('yonetim.oturumac');
    }
}
