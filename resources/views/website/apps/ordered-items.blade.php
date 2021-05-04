@extends('website.layout.app',['b_title'=>'داواکاری: '.$orders->oi_ID])
@section('content')
<div class="container">
    {{-- <h3 id="hopt" class="header right-align">سەبەتە</h3>
    <div class="divider"></div> --}}
    <div class="row">
        <div class="col s12 m4 right-align">
            <div class="card custom-side">
                @php
                $amount = 0;
                foreach ($orders->ordered as $key => $value) {
                $amount = $amount + $value->o_amount;
                }
                @endphp
                <p>کۆی سەرجەم داواکاریەکان: <span>{{$amount}} </span></p>
                <p><span>{{number_format($orders->oi_price_all)}} IQD</span> :نرخی کۆی گشتی گوڵەکان</p>
            </div>
        </div>
        <div class="col s12 m8">
            @forelse ($orders->ordered as $key => $item)
            @if ($item->o_group_by == 0)
            {{-- {{$item->item->ip_ID}} --}}
            <div class="card horizontal" style="width: 100% !important;padding: 10px;">
                <div>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <h5><b class="truncate">{{ $item->item->ip_name}}</b></h5>
                        <p>{{number_format($item->item->ip_price * $item->o_amount)}} IQD</p>
                        <p>{!!App\Helpers\Common::limit($item->item->ip_description )!!}</p>
                        <p>بڕ: {{$item->o_amount}}</p>
                    </div>

                </div>
                <div class="card-image cart-image"
                    style="background-image: url({{secure_asset('storage/'.$item->item->imageAvailable->i_link)}});">
                    <img src="{{secure_asset('storage/'.$item->item->imageAvailable->i_link)}}"
                        style="visibility: hidden;height: 150px;width:100px">
                </div>
            </div>
            @endif
            @empty
            @endforelse
            <!--//////////////////////////////////////////////////////-->
             @forelse ($count as $keys => $value_order)
            <ul class="collapsible  card horizontal" style="width: 100%;">
                <li style="width: 100%;">
                    <div class="collapsible-header" style="width: 100% !important">
                        <div class="card-stacked">
                            <div class="card-content right-align">
                                <h5><b class="truncate">چەپکە گوڵی هەڵبژێراو</b></h5>
                                <p class="">
                                    @php
                                    $all = 0;
                                    $gid = -1;
                                    @endphp
                                    @foreach ($value_order as $key => $order)
                                    @php

                                    $gid = $order->o_group_by;
                                    $all = $all + ($order->item->ip_price * $order->o_amount);
                                    @endphp
                                    @endforeach
                                    {{number_format($all)}}
                                    IQD</p>
                            </div>
                            <div class="card-action">
                                <a>بینینی جەپکەکە</a>
                            </div>
                        </div>
                        <div class="card-image cart-image"
                            style="background-image: url({{secure_asset('storage/image/placeholder_flower.png')}});">
                            <img src="{{secure_asset('storage/image/placeholder_flower.png')}}"
                                style="visibility: hidden;height: 150px;width:100px">
                        </div>
                    </div>
                    @foreach ($value_order as $key => $order)
                    <div class="collapsible-body right-align">
                        <div id="no-shadow" class="card horizontal no-shadow"
                            style="width: 100% !important;padding: 10px;box-shadow: 0 !important;-webkit-box-shadow: 0 !important;">

                            <div class="card-stacked">
                                <div class="card-content right-align">
                                    <b class="truncate">{{ $order->item->ip_name}}</b>
                                    <p >{{number_format($order->item->ip_price * $order->o_amount)}}
                                        IQD</p>
                                    <p>{!!App\Helpers\Common::limit($order->item->ip_description )!!}</p>
                                </div>
                            </div>

                            <div class="card-image cart-image"
                                style="background-image: url({{secure_asset('storage/'.$order->item->imageAvailable->i_link)}});">
                                <img src="{{secure_asset('storage/'.$order->item->imageAvailable->i_link)}}"
                                    style="visibility: hidden;height: 150px;width:100px">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </li>
            </ul>
            @empty
            <script>
                document.getElementById('opt').remove();
            </script>
            @endforelse
            <!--//////////////////////////////////////////////////////-->
        </div>
    </div>

</div>

@endsection