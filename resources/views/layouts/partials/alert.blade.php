@if(session()->has('mesaj'))
    <div class="container">
        <div  class="alert alert-{{session('mesaj_tur')}}" role="alert">{{session('mesaj')}}</div>
    </div>
@endif

<script>
    setTimeout(function (){
        $('.alert').slideUp(500);
    },3000);
</script>
