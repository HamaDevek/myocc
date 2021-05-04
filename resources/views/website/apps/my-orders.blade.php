@extends('website.layout.app',['b_title'=>'داواکاریەکانت'])
@section('content')
<div class="container">
    <div class="row" style="max-width: 600px;">
        <div class="col s12">
            <p id="title-pendding" class=" grey-text lighten-3 right-align" style="direction: rtl;">چاوەڕوانی</p>
            @php
                $i = 0;
            @endphp
            @forelse ($orders as $key => $item)
            @if ($item->oi_state == 0)
            @php
                $i++;
            @endphp
            <div class="card horizontal" style="width: 100% !important;padding: 10px 0;">
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <h5 style="margin-top: 0;"><b class="truncate"> داواکاری: {{ ++$key }}</b></h5>
                        <p>نرخی داروکاری: {{$item->oi_price_all}}</p>
                        @php
                        $amount = 0;
                        foreach ($item->ordered as $key => $value) {
                        $amount = $amount + $value->o_amount;
                        }
                        @endphp
                        <p>کۆی ژمارەی کاڵاکان: {{$amount}}</p>
                        <p>بەرواری داواکردن: {{$item->oi_to_date}}</p>
                        <p>کاتی داواکردن: {{$item->oi_to_time}}</p>
                    </div>
                    <div class="card-action">
                        <a href="{{route('order.show',['id'=>$item->oi_ID])}}">بینین</a>
                    </div>
                </div>
                <div class="card-image cart-image"
                    style="background-image: url({{secure_asset('storage/image/basket.png')}});">
                    <img src="{{secure_asset('storage/image/basket.png')}}"
                        style="visibility: hidden;height: 150px;width:100px">
                </div>
            </div>
            @endif
            @empty
            
            @endforelse
            @if ($i < 1)
            <script>
                document.getElementById('title-pendding').remove();
            </script>
            @endif
            <p id="title-done" class="  grey-text lighten-3 right-align" style="direction: rtl;">تەواوکراوەکان</p>
            @php
                $i = 0;
            @endphp
            @forelse ($orders as $key => $item)
            @if ($item->oi_state == 1)
            @php
                $i++;
            @endphp
            <div class="card horizontal" style="width: 100% !important;padding: 10px 0;">
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <h5 style="margin-top: 0;"><b class="truncate"> داواکاری: {{ ++$key }}</b></h5>
                        <p>نرخی داروکاری: {{$item->oi_price_all}}</p>
                        @php
                        $amount = 0;
                        foreach ($item->ordered as $key => $value) {
                        $amount = $amount + $value->o_amount;
                        }
                        @endphp
                        <p>کۆی ژمارەی کاڵاکان: {{$amount}}</p>
                        <p>بەرواری داواکردن: {{$item->oi_to_date}}</p>
                        <p>کاتی داواکردن: {{$item->oi_to_time}}</p>
                    </div>
                    <div class="card-action">
                        <a class="grey-text" href="{{route('order.show',['id'=>$item->oi_ID])}}">بینین</a>
                    </div>
                </div>
                <div class="card-image cart-image"
                    style="background-image: url({{secure_asset('storage/image/basket.png')}});">
                    <img src="{{secure_asset('storage/image/basket.png')}}"
                        style="visibility: hidden;height: 150px;width:100px">
                </div>
            </div>
            @endif
            @empty
        
            
            @endforelse
            @if ($i < 1)
            <script>
                document.getElementById('title-done').remove();
            </script>
            @endif
            

        </div>

    </div>

</div>
@endsection