@extends('website.layout.app')
@section('content')
<div class="container" style="margin: auto;" dir="rtl">
    <form method="POST" action="{{route('login.checkaccount',['id'=>$id])}}" class="col s12 login-page"
        style="margin: auto;padding: 24px;">
        @csrf
        @method('POST')
        <h4 class="right-align">چالاک کردن</h4>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">کۆدی چالاک کردن</label>
                <input type="text" name="code" class="validate">
            </div>
        </div>
        <div class="row center">
            <button class="waves-effect waves-light pink lighten-3 white-text btn" type="submit" name="action">
                چالاک کردن
            </button>

        </div>
    </form>

</div>
@endsection