@if(session()->has('mesaj'))
    <div class="container">
        <div class="alert alert-{{session('mesaj_turu')}}">{{session('mesaj')}}</div>
    </div>
@endif
