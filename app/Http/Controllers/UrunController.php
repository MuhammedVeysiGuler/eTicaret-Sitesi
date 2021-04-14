<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrunController extends Controller
{
    public function index(){
        return view('urun');
    }
}
