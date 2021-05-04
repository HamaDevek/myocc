@extends('website.layout.app')
@section('content')
<div class="container" style="margin: auto;" dir="rtl">
    <form action="{{route('login.login')}}" method="POST" class="col s12 login-page"
        style="margin: auto;padding: 24px;">
        @csrf
        @method('POST')
        <h4 class="right-align">چوونە ژوورەوە</h4>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ژ.مۆبایل</label>
                <input type="tel" name="phone" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ووشەی نهێنی</label>
                <input name="password" type="password" class="validate">
            </div>
        </div>

        <div class="row center">
            <button class="waves-effect waves-light pink lighten-3 white-text btn" type="submit" name="action">

                چوونە ژوورەوە
            </button>
        </div>
        <p class="center" style="margin: 30px auto;">هەژمارت نییە؟ <a href="{{route('login.create')}}"
                class="pink-text">هەژمار دروست
                بکە</a></p>
    </form>
</div>
@endsection