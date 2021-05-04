@extends('website.layout.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/css/swiper.min.css"
    integrity="sha256-DBYdrj7BxKM3slMeqBVWX2otx7x4eqoHRJCsSDJ0Nxw=" crossorigin="anonymous" />
<div class="slider" style="background-color: #fafafa;">
    <ul class="slides">
        @foreach ($banner as $img)
        <li>
            <img src="{{secure_asset('storage/'.$img->image)}}">
            <div class="caption {{$img->class}}">
                <h3 class="dark black-text ">{!!$img->title!!}</h3>
                <h6 class="dark black-text " style="line-height: 1.8rem;">{!!$img->desc!!}
                </h6>
                <br>
                <a class="waves-effect waves-dark btn white black-text">بازاڕبکە</a>
            </div>
        </li>
        @endforeach
    </ul>
</div>
<div style="background-color: #fafafa;">
    <div class="white   z-depth-1">
        <div class="container">
            <ul id="tabs-swipe-demo" class="tabs   tab-demo  row ">
                <li class="tab col s3">
                    <a target="_self" href="{{route('search.index')}}" class="left-align" style="padding-right:0;">
                        سەرجەم کاڵاکان
                    </a>
                </li>
                <li class="tab col s3"><a href="#test-swipe-3" id="plant">ئینجانە</a></li>
                <li class="tab col s3"><a href="#test-swipe-2" id="gift">دیاری</a></li>
                <li class="tab col s3"><a href="#test-swipe-1" id="flower" class="active">چەپکە گوڵ</a></li>

            </ul>
        </div>
    </div>
    <div id="test-swipe-1">
        <div class="swiper-container left" dir="rtl" style="width: 100%;padding: 10px 15px !important;">
            <div class="swiper-wrapper">
                @foreach($flower as $d)
                <div class="swiper-slide  hoverable">
                    <span class="item-image "
                        style="background-image: url({{secure_asset('storage/'.$d->image)}});background-position: center;">
                    </span>
                    <span class="item-title">
                        {{$d->name}}
                    </span>
                    <span class="item-description text-lighten-3">
                        {{number_format($d->price)}} IQD
                    </span>
                    <a href="/item/{{$d->value}}" class="btn-floating waves-effect waves-light pink "><i
                            class="material-icons">add</i></a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="test-swipe-2">
        <div class="swiper-container left" dir="rtl" style="width: 100%;padding: 10px 15px !important;">
            <div class="swiper-wrapper">
                @foreach($gift as $d)
                <div class="swiper-slide  hoverable">
                    <span class="item-image "
                        style="background-image: url({{secure_asset('storage/'.$d->image)}});background-position: center;">
                    </span>
                    <span class="item-title">
                        {{$d->name}}
                    </span>
                    <span class="item-description text-lighten-3">
                        {{number_format($d->price)}} IQD
                    </span>
                    <a href="/item/{{$d->value}}" class="btn-floating waves-effect waves-light pink "><i
                            class="material-icons">add</i></a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="test-swipe-3">
        <div class="swiper-container left" dir="rtl" style="width: 100%;padding: 10px 15px !important;">
            <div class="swiper-wrapper">
                @foreach($plant as $d)
                <div class="swiper-slide  hoverable">
                    <span class="item-image "
                        style="background-image: url({{secure_asset('storage/'.$d->image)}});background-position: center;">
                    </span>
                    <span class="item-title">
                        {{$d->name}}
                    </span>
                    <span class="item-description text-lighten-3">
                        {{number_format($d->price)}} IQD
                    </span>
                    <a href="/item/{{$d->value}}" class="btn-floating waves-effect waves-light pink "><i
                            class="material-icons">add</i></a>
                </div>
                @endforeach
            </div>
        </div>
    </div>


</div>
<div class="conteiner">
    <div class="row">
        <div class="parallax-container center-align">
            <div class="parallax"><img src="{{secure_asset('storage/'.$extra->image)}}"></div>
            <h4 class="center-align white-text">
                <br>
                {{$extra->title}}

            </h4>
            <br>
            <a href="{{route('custom.index')}}"
                class="waves-effect waves-light btn pink lighten-3 white-text btn-large ">هەڵبژاردن و دروستکردن</a>

        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col s12">
            <h3 class="right-align">
                ئۆفەرەکانمان
            </h3>
        </div>
    </div>

    <div class="row" style="direction: rtl !important;">

        @foreach ($offer as $item)
        <div class="col s12 m4">

            <a href="/item/{{$item->value}}" class="card card-big hoverable">

                <div class="card-image"
                    style="background-size: cover; background-image: url({{secure_asset('storage/'.$item->image)}});">
                    <img src="{{secure_asset('storage/'.$item->image)}}" style="height: 400px;opacity: 0;">
                    <span class="card-title">{{$item->name}}
                        <br>
                        <i class="price text-lighten-4">{{number_format($item->price)}} IQD</i>
                    </span>

                </div>

            </a>

        </div>
        @endforeach
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"
    integrity="sha256-4sETKhh3aSyi6NRiA+qunPaTawqSMDQca/xLWu27Hg4=" crossorigin="anonymous"></script>
<script>
    var z;
        function myFunction(x) {
            if (x.matches) { // If media query matches
                z = 2;
            } else {
                z = 5;
            }

        }

        var x = window.matchMedia("(max-width: 700px)");
        myFunction(x); // Call listener function at run time
        x.addListener(myFunction);// Attach listener function on state

        var swiper = new Swiper('.swiper-container', {
            slidesPerView: z,
            spaceBetween: 15,
            centeredSlides: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
</script>

@endsection