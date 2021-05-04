@extends('website.layout.app')
@section('content')

<div class="container">
    <form class="col s12 login-page" id="form-change-password" style="margin: auto;padding: 24px;"
        action="{{route('login.passwordchange')}}" method="POST">
        @csrf
        <div class="row right-align">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;right:5px">ووشەی نهێنی</label>
                <input placeholder="************" type="password" name="password" class="validate">
            </div>
        </div>
        <div class="row right-align">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;right:5px">ووشەی نهێنی نوێ</label>
                <input type="password" name="password_new" class="validate">
            </div>
        </div>
        <div class="row right-align">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;right:5px">دڵنیابوونەوەی ووشەی نهێنی</label>
                <input type="password" name="password_verify" class="validate">
            </div>
        </div>
        <center>
            <a class="center btn pink lighten-3 " onclick="submitForm(this)">هەڵگرتن</a>
        </center>
    </form>
</div>
<script>
    function submitForm(x) {
        x.classList.add("disabled");
        var form = document.getElementById('form-change-password');
        form.submit();
    }
</script>
@endsection