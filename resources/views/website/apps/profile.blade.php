@extends('website.layout.app')
@section('content')
<div class="container right-align" style="margin: 15px auto">
    <div dir="rtl" class="row">
        <div class="col s12 m4">
            <div class="custom-side card">
                <p>ئەو <a href="{{route('order.index')}}" class="pink-text">کالایانەی</a> پێشتر کڕیوتن</p>
            </div>
            <div class="custom-side card">
                <p> <a href="{{route('order.carts')}}" class="pink-text">سەبەتەکەت</a> لە ئێستادا</p>
            </div>
            <div class=" card custom-side">
                <p> <a href="{{route('login.passwordshow')}}" class="pink-text">گۆڕینی</a> وشەی نهێنیەکەت</p>
            </div>
            <form class="custom-side card" method="POST" action="{{route('submit.deletemap')}}"
                id="delete-saved-address">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div class="input-field col s11 right-align right" style="box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;">ناونیشان</label>
                        <select class="select" name="saved_address">
                            <option style="padding: 0" disabled selected>ناونیشانەکەت</option>
                            @foreach ($account->saved_location as $item)
                            <option value="{{$item->sa_ID}}">{{$item->sa_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="height: 75px;display: flex;justify-content: center;margin-top:auto;" class="col s1">
                        <a href="#!" onclick="deleteForm(this)" style="margin-top:auto"><i
                                class="material-icons">delete</i></a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col s12 m8 right">
            <form class="card" id="form-sub" enctype="multipart/form-data" method="POST"
                action="{{route('profile.update',['profile'=>$account->a_ID])}}" style="padding: 10px 15px;">
                @csrf
                @method('PUT')
                <div style="margin: 20px 0">
                    <button type="button" id="upload" style="background-position: center;background-image: url({{secure_asset('storage/'.$account->a_image)}});background-repeat: no-repeat;
                        background-size: cover;"></button>
                    <input id="actual-upload" name="image" onchange="readURL(this)" style="display: none" type="file">
                </div>
                <div class="row">
                    <div class="input-field col s6 " style="width: 100%;box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;">ناو</label>
                        <input placeholder="جۆن دۆیی" name="name" value="{{$account->a_name}}" type="text"
                            class="validate">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                        <label style="position:inherit;">ژ.مۆبایل</label>
                        <input disabled placeholder="٠٧٧٠٧٧٧٧٧٧٧" name="phone" value="{{$account->a_phone}}" type="text"
                            class="validate">
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;">ناونیشان</label>
                        <textarea placeholder="سلێمانی تازە نزیک سلێمانی کۆن" name="address"
                            class="materialize-textarea">{{$account->a_address}}</textarea>
                    </div>
                </div>

                <div class="input-field col s12 right-align">
                    <label class="active" style="position:inherit;">شوێنی نیشتەجێبوون</label>
                    <select class="select" name="location">
                        <option style="padding: 0" value="" disabled>شارەکەت</option>
                        @foreach ($location as $item)
                        <option {{$item->l_ID == $account->a_l_ID ? 'selected' : ''}} value="{{$item->l_ID}}">
                            {{$item->l_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                        <label class="active" style="position:inherit;">ووشەی نهێنی</label>
                        <input name="password" placeholder="************" type="password" class="validate">
                    </div>
                </div>
                <center>
                    <a class="center btn pink lighten-3 " onclick="submitForm(this)">هەڵگرتن</a>
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
function deleteForm(x){
    x.classList.add("disabled");
    var form = document.getElementById('delete-saved-address');
    form.submit();
}
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