@extends('website.layout.app',['b_title'=>$about->title])
@section('content')
{{-- <div class="parallax-container center-align">
    <div class="parallax"><img src="{{secure_asset('storage/'. $about->image)}}"></div>
<h3 class="center-align white-text"><br><br>{{$about->title}}</h3>
</div> --}}
<div class="container">
    <div class="row">
        <div class="col s12">
            <p class="right-align " style="font-size: 16px;padding: 30px 0;">
                {!! $about->desc !!}
            </p>
        </div>
    </div>

</div>
@endsection