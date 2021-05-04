@extends('website.layout.app',[
'b_title' => ':هەنگاوی یەکەم',
'b_disc' => 'جۆری گوڵ دیاری بکە',
])
@section('content')
<style>
    .card .card-content,
    .card .horizontal,
        {
        padding: 10px 0px !important;
    }

    .selected-custom-item {
        padding: 10px 0;
    }
</style>
<div class="container">

    <form action="{{route('custom.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col s12">
                <ul class="tabs" style="display: none;">
                    <li class="tab col s3"><a href="#fl">گوڵ</a></li>
                    <li class="tab col s3"><a href="#wr">وەرەقە</a></li>
                    <li class="tab col s3"><a href="#lc">قردێلە</a></li>
                </ul>
            </div>
            <div id="fl" class="tb col s12">
                @foreach ($flower as $item)
                <div class="col s6 m3 right" dir="rtl" style="padding:0">
                    <div onclick="" class="card center-align selected-custom-item" style="margin: 16px 8px 0;flex-direction:column;">
                        <div class="card-image "
                            style="background-image: url({{secure_asset('storage/'.$item->image)}});">
                            <img src="{{secure_asset('storage/'.$item->image)}}"
                                style="visibility: hidden;height: 150px;width:100%">
                        </div>
                        <div class="card-stacked">
                            <div class="card-content" style="padding: 0">
                                <p><b class="truncate">{{$item->name}}</b></p>
                                <p class="truncate">{{$item->price}} IQD</p>
                            </div>
                            <div class="number-input" style="padding: 0;width: 100%;">
                                <p style="margin-left:8px"></p><button type="button"
                                    onclick="increaseValue(this)">+</button><input id=""
                                    class="input-number number center-align" type="number" name="item[{{$item->value}}]"
                                    value="0" min="0"><button type="button" onclick="decreaseValue(this)">-</button>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
            <div id="wr" class="tb col s12"> @foreach ($wrapper as $item)
                <label class="col s6 m3 right card-check" dir="rtl" style="padding:0;">
                    <input name="waraqa[{{$item->value}}]" type="checkbox">
                    <span style="width: 100%;height: 100%;">
                        <div onclick="checks(this)" class="card center-align selected-custom-item"
                            style="margin: 16px 8px 0;flex-direction:column;">
                            <div class="card-image "
                                style="background-image: url({{secure_asset('storage/'.$item->image)}});">
                                <img src="{{secure_asset('storage/'.$item->image)}}"
                                    style="visibility: hidden;height: 150px;width:100%">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content" style="padding: 0">
                                    <p><b class="truncate">{{$item->name}}</b></p>
                                    <p class="truncate">{{$item->price}} IDQ</p>
                                </div>
                            </div>
                            <input type="hidden" isselected="false" amount="0" value="">
                        </div>
                    </span>
                </label>
                @endforeach</div>
            <div id="lc" class="tb col s12"> @foreach ($lace as $item)<label class="col s6 m3 right card-check"
                    dir="rtl" style="padding:0;">
                    <input name="qrdela[{{$item->value}}]" type="checkbox">
                    <span style="width: 100%;height: 100%;">
                        <div onclick="checks(this)" class="card center-align selected-custom-item"
                            style="margin: 16px 8px 0;flex-direction:column;">
                            <div class="card-image "
                                style="background-image: url({{secure_asset('storage/'.$item->image)}});">
                                <img src="{{secure_asset('storage/'.$item->image)}}"
                                    style="visibility: hidden;height: 150px;width:100%">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content" style="padding: 0">
                                    <p><b class="truncate">{{$item->name}}</b></p>
                                    <p class="truncate">{{$item->price}} IDQ</p>
                                </div>
                            </div>
                            <input type="hidden" isselected="false" amount="0" value="">
                        </div>
                    </span>
                </label>

                @endforeach</div>

        </div>
        <div class="row" style="margin-left: -8px;margin-right: -8px;">

        </div>
        <center style="margin-top: auto">
            <button id="back_s" type="button" onclick="re_back()" class="waves-effect grey lighten-4 black-text btn"
                style="margin-right: 15px">گەڕانەوە</button>
            <button id="forwards" type="button" onclick="forward()"
                class="waves-effect lighten-4 pink btn">دواتر</button>
        </center>
        <br>
    </form>


</div>
<script>
    function checks(checker){
    $(checker).toggleClass("black-text");
   }
    function forward() {
        
        $('#back_s').show();
        var x = $('.tb.active').next().attr('id');
        if(x === undefined){
            $('#forwards').attr('type', 'submite');
        }else{
        $('.tabs').tabs('select',x);
        }
        switch (x) {
            case 'fl':
            $('#b_title').text(':هەنگاوی یەکەم');
            $('#b_disc').text('جۆری گوڵ دیاری بکە');
                break;
                case 'wr':
            $('#b_title').text(':هەنگاوی دووەم');
            $('#b_disc').text('جۆری وەرەقەکە دیاری بکە');
                break;
                case 'lc':
            $('#b_title').text(':هەنگاوی سێیەم');
            $('#b_disc').text('جۆری قردێلە دیاری بکە');
                break;
        
            default:
                break;
        }
    }
    $('#back_s').hide();
    function re_back() {
        var x = $('.tb.active').prev().attr('id');
        if(x === undefined){
            $('#back_s').hide();
        }else{
            $('.tabs').tabs('select',x);
            if($('.tb.active').prev().attr('id') == undefined){
                $('#back_s').hide();
            }
        }
        switch (x) {
            case 'fl':
            $('#b_title').text(':هەنگاوی یەکەم');
            $('#b_disc').text('جۆری گوڵ دیاری بکە');
                break;
                case 'wr':
            $('#b_title').text(':هەنگاوی دووەم');
            $('#b_disc').text('جۆری وەرەقەکە دیاری بکە');
                break;
                case 'lc':
            $('#b_title').text(':هەنگاوی سێیەم');
            $('#b_disc').text('جۆری قردێلە دیاری بکە');
                break;
        
            default:
                break;
        }
    }
    function increaseValue(x) {
    var value = parseInt(x.parentElement.querySelector('input').value);
    value = isNaN(value) ? 0 : value;
    value++;
    x.parentElement.querySelector('input').value = value;
}
function decreaseValue(x) {
    var value = parseInt(x.parentElement.querySelector('input').value);
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    value--;
    x.parentElement.querySelector('input').value = value;
}
</script>
@endsection