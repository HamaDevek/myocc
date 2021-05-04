@extends('website.layout.app')
@section('content')
<div class="container" dir="rtl">
    <form class="col s12 login-page" method="POST" action="{{route('submit.done',['type'=>$type])}}">
        @csrf
        @method('POST')
        <div class="row">
            <div class="input-field col s12 " style="box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناوی کڕیار</label>
                <input type="text" name="name_from" value="{{ old('name_from') }}" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12" style="box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ژ.مۆبایلی کڕیار</label>
                <input type="text" name="phone_from" value="{{ old('phone_from') }}" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s11 right-align right" style="box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناونیشان</label>
                <select onchange="fromChange(this);" class="select">
                    <option style="padding: 0" value="" disabled selected>ناونیشانەکەت</option>
                    @foreach ($location as $item)
                    <option value="{{$item->sa_ID}}">{{$item->sa_name}}</option>
                    @endforeach
                </select>
            </div>
            <div style="height: 75px;display: flex;justify-content: center;margin-top:auto;" class="col s1"><a
                    href="{{route('submit.map',['type'=>$type])}}" style="margin-top:auto"><i
                        class="material-icons">location_on</i></a></div>
        </div>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناونیشان</label>
                <textarea name="address_from" id="address_from"
                    class="materialize-textarea">{{ old('address_from')}}</textarea>
            </div>
        </div>
        <div class="row">
            <div data-position="top" data-tooltip="تکایە بۆ گۆڕینی شوێنی نیشتەجێ بوون سەردانی هەژمارەکەت بکە"
                class="tooltipped input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">شاری نیشتەجێبوون</label>
                <input type="text" disabled value="{{$loc}}">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 right" style="box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">پەیام</label>
                <textarea name="message" class="materialize-textarea">{{ old('message') }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col s12" style="box-shadow: 0;margin: 0;">
                <label style="position:inherit;margin-right: 5px;font-size: 14px">ڕۆژی ناردن</label>
                <input name="date" value="{{ old('date') }}" type="text" class="datepicker">
            </div>
        </div>
        <div class="row">
            <div class="col s12" style="box-shadow: 0;margin: 0;">
                <label style="position:inherit;margin-right: 5px;font-size: 14px">کاتی ناردن</label>
                <input name="time" value="{{ old('time') }}" type="text" class="timepicker">
            </div>
        </div>

        @if ($type == 1)

        <div class="row">
            <div class="input-field col s12 " style="box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناوی وەرگر</label>
                <input type="text" name="name_to" value="{{ old('name_to') }}" class="validate">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="input-field col s12" style="box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ژ.مۆبایلی وەرگر</label>
                <input type="text" name="phone_to" value="{{ old('phone_to') }}" class="validate">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s11 right-align right" style="box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناونیشان</label>
                <select onchange="toChange(this);" class="select">
                    <option style="padding: 0" value="" disabled selected>ناونیشانەکەت</option>
                    @foreach ($location as $item)
                    <option value="{{$item->sa_ID}}">{{$item->sa_name}}</option>
                    @endforeach
                </select>
            </div>
            <div style="height: 75px;display: flex;justify-content: center;margin-top:auto;" class="col s1"><a
                    href="{{route('submit.map',['type'=>$type])}}" style="margin-top:auto"><i
                        class="material-icons">location_on</i></a></div>
        </div>
        <div class="row">
            <div class="input-field col s6" style="width: 100%;box-shadow: 0;margin: 0;">
                <label class="active" style="position:inherit;">ناونیشانی وەرگر</label>
                <textarea name="address_to" id="address_to"
                    class="materialize-textarea">{{ old('address_to')}}</textarea>
            </div>
        </div>
        <div class="input-field col s12 right-align">
            <label class="active" style="position:inherit;">شوێنی نیشتەجێبوونی وەرگر</label>
            <select class="select" name="address_to_gift">
                <option style="padding: 0" value="" disabled selected>شارەکەت</option>
                @foreach ($address as $item)
                <option value="{{$item->l_ID}}">{{$item->l_name}}</option>
                @endforeach
            </select>
        </div>
        @endif
        <br>
        <div class="row center">
            <button class="waves-effect waves-light pink lighten-3 white-text btn" type="submit" name="action">
                تۆماری بکە
            </button>
        </div>

    </form>
</div>
<script>
    function toChange(x) {
        var abc = document.getElementById('address_to');
        abc.value = x.options[x.selectedIndex].text;
    }
    function fromChange(x) {
        var abc = document.getElementById('address_from');
        abc.value = x.options[x.selectedIndex].text;
    }
</script>
@endsection