@extends('website.layout.app',['b_title'=>'پەیوەندیەکان'])
@section('content')
<div class="container right-align" style="margin: 15px auto">
    <div dir="rtl" class="row">
        <div class="col s12 m4">
            <div style="padding: 10px 15px;" class="card">
                <p>ژمارەی مۆبایل: {{$contact->con_phone}}</p>
                <p>ناو نیشان:{{$contact->con_address}}</p>
                <p>ئیمەیڵ:{{$contact->con_email}}</p>
            </div>
        </div>
        <div class="col s12 m8 right">
            <form method="POST" class="card" id="form-sub" action="{{route('contact.mail')}}"
                style="padding: 10px 15px;">
                @csrf
                <h4 class="right-align">هیچ پرسیارێکت هەیە؟</h4>
                <div class="row">
                    <div class="input-field col s6 " style="width: 100%;box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;right:5px">ناو</label>
                        <input placeholder="جۆن دۆیی" type="text" value="{{old('name')}}" name="name" class="validate">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;right:5px">ژ.مۆبایل</label>
                        <input placeholder="٠٧٧٠٧٧٧٧٧٧٧" name="phone" value="{{old('phone')}}" type="text"
                            class="validate">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;right:5px">ئیمەیڵ</label>
                        <input placeholder="johndoe@example.com" name="email" value="{{old('email')}}" type="text"
                            class="validate">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;right:5px">ناوەڕۆك</label>
                        <textarea placeholder="" name="content"
                            class="materialize-textarea">{{old('content')}}</textarea>
                    </div>
                </div>
                <div class="row left-align">
                    <div class="input-field">
                        <div class="g-recaptcha" data-sitekey="6Ldx190UAAAAAKaRV3miD8A40qHEJ8VNpk6npK6w"></div>
                    </div>
                </div>
                <center>
                    <a onclick="submitForm(this)" class="center btn pink lighten-3">هەڵگرتن</a>
                </center>
                <br>
            </form>
        </div>
    </div>
</div>
<script>
    function submitForm(x){
    x.classList.add("disabled");
    var form = document.getElementById('form-sub');
    form.submit();
}
</script>
@endsection