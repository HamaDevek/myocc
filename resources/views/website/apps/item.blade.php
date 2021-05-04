@extends('website.layout.app')
@section('content')

<div class="container right-align" style="margin: 15px auto">
    <div class="row">
        <div class="col s12 m6 right">
            <div class="card" dir="rtl">
                <div class="carousel carousel-slider" style="position: relative;">
                    @foreach ($data->image as $img)
                    <a class="carousel-item full-bg" href="#!"
                        style="background-image: url({{secure_asset('storage/'.$img->i_link)}});">
                        <img src="{{secure_asset('storage/'.$img->i_link)}}" style="visibility: hidden;">
                    </a>
                    @endforeach
                </div>
            </div>
            <br>
        </div>
        <div class="col s12 m6 flower-desc">
            <h4><b>گوڵە باخ</b></h4>
            <div class="right-align">
                <h6>{{number_format($data->ip_price)}} IQD</h6>
                <p>{!! $data->ip_description !!}</p>
            </div>
            <div style="margin-top: auto;">
                <a class="waves-effect waves-light btn pink lighten-3 white-text modal-trigger"
                    href="#modal1">داواکردن</a>
            </div>
        </div>
    </div>
    <br>
</div>

<div id="modal1" class="modal bottom-sheet">
    <div class="modal-content">
        <form id="form-submit" action="{{route('item.orderstore',['id'=>$data->ip_ID])}}" method="post">
            <div class="modal-content">
                <h4 class="right-align">برێک دیاریکە</h4>
                @csrf
                @method('POST')

                <div class="row right-align">
                    <div class="input-field col s12">
                        <label class="active" name="phone_to" style="position:inherit;">بڕ</label>
                        <input id="amounts" type="number" min="1" max="999" name="amounts" class="validate">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a href="#!" onclick="submitForm(this)" class="modal-close waves-effect waves-green btn-flat">هەڵگرتن</a>
    </div>
</div>
<script>
    function submitForm(x){
    x.classList.add("disabled");
    var form = document.getElementById('form-submit');
    form.submit();
}
</script>

{{-- 
<div class="container right-align" style="margin: 15px auto">
    <div class="row">
        <div class="col s12 m6 right">
            <div class="card" dir="rtl">
                <div class="carousel carousel-slider" style="position: relative;">
                    @foreach ($data->image as $img)
                    <a class="carousel-item full-bg" href="#!"
                        style="background-image: url({{secure_asset('storage/'.$img->i_link)}});">
<img src="{{secure_asset('storage/'.$img->i_link)}}" style="visibility: hidden;">
</a>
@endforeach
</div>
</div>
<br>
</div>
<div class="col s12 m6">
    <h4><b>{{$data->ip_name}}</b></h4>
    <div class="right-align">
        <h6><b class="pink-text text-lighten-3">
                {{number_format($data->ip_price)}} IQD
            </b></h6>
        <p>{!! $data->ip_description !!}</p>
    </div>
</div>
</div>
<div class="center">
    <a class="waves-effect waves-light btn grey black-text  lighten-3 " href="{{url()->previous()}}">گەڕانەوە</a>&nbsp;
    &nbsp; <a href="#amount" class="waves-effect waves-light btn pink lighten-3 white-text modal-trigger ">داواکردن</a>
</div>
<br>
</div>
<!-- Modal Structure -->
<div id="amount" style="max-height: 100% !important;border-top-right-radius: 25px;border-top-left-radius: 25px"
    class="modal bottom-sheet">
    <form action="{{route('item.orderstore',['id'=>$data->ip_ID])}}" method="post">
        <div class="modal-content">
            <h4 class="right-align">برێک دیاریکە</h4>
            @csrf
            @method('POST')

            <div class="row right-align">
                <div class="input-field col s12">
                    <label class="active" name="phone_to" style="position:inherit;">بڕ</label>
                    <input id="amounts" type="number" min="1" max="999" name="amounts" class="validate">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class=" waves-effect btn-flat">هەڵگرتن</button>
        </div>
    </form>
</div> --}}
@endsection