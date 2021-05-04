@extends('website.layout.app')
@section('content')

<div class="container" dir="rtl">
    <form class="col s12 login-page" action="{{route('login.register')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <h4 class="right-align">دروستکردنی هەژمار</h4>
        <div style="margin: 22px 0">
            <input type='file' id="actual-upload" onchange="readURL(this);" name="imgs" style="display: none" />
            <button type="button" id="upload"
                style="background-position: center;background-repeat: no-repeat;background-image: url('{{secure_asset('storage/image/photo.png')}}');background-position: center;"></button>

        </div>
        <div class="row">
            <div class="input-field col s6 " style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناوی تەواو</label>
                <input type="text" name="name" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ژ.مۆبایل</label>
                <input type="tel" name="phone" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناونیشان</label>
                <textarea name="address" class="materialize-textarea"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ووشەی نهێنی</label>
                <input type="password" name="password" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">دڵنیابونەوەی وشەی نهێنی</label>
                <input type="password" name="password_verify" class="validate">
            </div>
        </div>
        <div class="input-field col s12 right-align">
            <label class="active" style="position:inherit;">شوێنی نیشتەجێبوون</label>
            <select class="select" name="location">
                <option style="padding: 0" value="" disabled selected>شارەکەت</option>
                @foreach ($location as $item)
                <option value="{{$item->l_ID}}">{{$item->l_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="row center">
            <button class="waves-effect waves-light pink lighten-3 white-text btn" type="submit" name="action">
                تۆماری بکە
            </button>
        </div>

        <p class="center" style="margin: 30px auto;">هەژمارت هەیە؟ <a href="{{route('login.show')}}"
                class="pink-text">چوونە ژوورەوە</a></p>
    </form>

</div>
<script>
    document.getElementById('upload').onclick = function() {
    document.getElementById('actual-upload').click();
};
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                     $('#upload').css("background-image", "url("+e.target.result+")");           
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

</script>
@endsection