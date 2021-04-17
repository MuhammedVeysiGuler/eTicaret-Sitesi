<h1>{{config('app.name Basarili Kayit Maili')}}</h1>
<p>Merhaba {{$user->adsoyad}}, kayıt işlemin başarılı bir şekilde gerçekleşti.</p>
<p>Kayıt aktifleştirme için <a href="{{config('app.url')}}/kullanici/aktiflestir/{{$user->aktivasyon_anahtari}}">tıklayın</a>veya linki açın</p>
{{config('app.url')}}/kullanici/aktiflestir/{{$user->aktivasyon_anahtari}}
