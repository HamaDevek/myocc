@extends('website.layout.app',['b_title'=>'سەبەتە'])
@section('content')
<style>
    @media only screen and (max-width: 601px) {
        .number-input {
            padding: 0 0 10px 0;
        }
    }
</style>
<div class="container">
    <div class="row">
        <div class="col s12 m4 right-align">
            <div class="card custom-side">

                <p>کۆی سەرجەم داواکاریەکان: <span id="all-item-amount">{{$order_info->amounts}} </span></p>
                <p><span id="all-item-price">{{number_format($order_info->prices)}} IQD</span> :نرخی کۆی گشتی گوڵەکان
                </p>
                <p>
                    <label class="gift-item">
                        <input type="checkbox" class="filled-in" onchange="changeType(this)" />
                        <span class="black-text">ئەمەم بۆ هەدیەیە</span>
                    </label>
                </p>
                <p><a id="typetogo" href="{{route('submit.order',['type'=>0])}}" class="btn-small small pink lighten-3"
                        style="width: 100%;">داواکردن</a></p>
            </div>
        </div>
        <div class="col s12 m8">
            @forelse ($orders as $key => $order)
            @if ( $order->c_group_by == 0)
            <div class="card horizontal" style="width: 100% !important;padding: 10px;">
                <div>
                </div>
                <div class="card-stacked">
                    <div class="card-content right-align">
                        <h5><b class="truncate">{{ $order->item->ip_name}}</b></h5>
                        <p>{{number_format($order->item->ip_price * $order->c_amount)}} IQD</p>
                        <p>{!!App\Helpers\Common::limit($order->item->ip_description )!!}</p>
                    </div>
                    <div class="number-input">
                        <p style="margin-left: 15px;"></p>
                        <button type="button"
                            onclick="increaseValue(this,'{{route('edit.carts',['id' => $order->c_ID])}}')"><b>+</b></button>
                        <form action="{{route('edit.carts',['id' => $order->c_ID])}}" method="post">
                            @csrf
                            @method('PUT')
                            <input class="input-number number"
                                onchange="insert(this,'{{route('edit.carts',['id' => $order->c_ID])}}')" type="number"
                                name="amounts" value="{{ $order->c_amount}}" min="0">
                        </form>
                        <button type="button"
                            onclick="decreaseValue(this,'{{route('edit.carts',['id' => $order->c_ID])}}')"><b>-</b></button>
                    </div>
                    <div class="card-action" style="display: flex;width: 100%;justify-content: flex-end;">
                        <form style="display: flex;width: 100%;justify-content: flex-end;"
                            action="{{route('order.delete',['id'=>$order->c_ID])}}" method="post">
                            <a onclick="updateAmount(this)" href="#!"
                                style="margin-left: auto;margin-right: 0;">هەڵگرتن</a>
                            @csrf
                            @method('DELETE')
                            <a onclick="submitForm(this);" href="#!">سڕینەوە</a>
                            <a href="/item/{{$order->item->ip_ID}}">بینین</a>
                        </form>

                    </div>
                </div>

                <div class="card-image cart-image"
                    style="background-image: url({{secure_asset('storage/'.$order->item->imageAvailable->i_link)}});">
                    <img src="{{secure_asset('storage/'.$order->item->imageAvailable->i_link)}}"
                        style="visibility: hidden;height: 150px;width:100px">
                </div>
            </div>
            @endif
            @empty
            <script>
                document.getElementById('hopt').remove();
            </script>
            @endforelse
            <p id="opt" class="grey-text lighten-3 right-align">داواکاری تایبەت</p>
            @forelse ($count as $keys => $orders)
            <ul class="collapsible  card horizontal" style="width: 100%;">
                <li style="width: 100%;">
                    <div class="collapsible-header" style="width: 100% !important">
                        <div class="card-stacked">
                            <div class="card-content right-align">
                                <h5><b class="truncate">چەپکە گوڵی هەڵبژێراو</b></h5>
                                <p>
                                    @php
                                    $all = 0;
                                    $gid = -1;
                                    @endphp
                                    @foreach ($orders as $key => $order)
                                    @php

                                    $gid = $order->c_group_by;
                                    $all = $all + ($order->item->ip_price * $order->c_amount);
                                    @endphp
                                    @endforeach
                                    {{number_format($all)}}
                                    IQD</p>
                            </div>
                            <div class="number-input" style="visibility: hidden;">
                                <p style="margin-left: 15px;"></p><button onclick="increaseValue()">+</button><input
                                    class="input-number number" type="number" value="1" min="0"><button
                                    onclick="decreaseValue()">-</button>
                            </div>
                            <div class="card-action" style="display: flex;width: 100%;justify-content: flex-end;">
                                <form action="{{route('custom.destroy',['custom'=>$gid])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a onclick="submitForm(this);" href="#!">سڕینەوە</a>
                                    <a>بینینی جەپکەکە</a>
                                </form>

                            </div>
                        </div>
                        <div class="card-image cart-image"
                            style="background-image: url({{secure_asset('storage/image/placeholder_flower.png')}});">
                            <img src="{{secure_asset('storage/image/placeholder_flower.png')}}"
                                style="visibility: hidden;height: 150px;width:100px">
                        </div>
                    </div>
                    @foreach ($orders as $key => $order)
                    <div class="collapsible-body right-align">
                        <div id="no-shadow" class="card horizontal no-shadow"
                            style="width: 100% !important;padding: 10px;box-shadow: 0 !important;-webkit-box-shadow: 0 !important;">

                            <div class="card-stacked">
                                <div class="card-content right-align">
                                    <h5><b class="truncate">{{ $order->item->ip_name}}</b></h5>
                                    <p>{{number_format($order->item->ip_price * $order->c_amount)}}
                                        IQD</p>
                                    <p>{!!App\Helpers\Common::limit($order->item->ip_description )!!}</p>
                                </div>
                                @php
                                $isVisible = 'display:flex';
                                $order->item->type->tp_name == 'وەرەقە' ? $isVisible = 'display:none' :
                                $order->item->type->tp_name == 'قردێلە' ? $isVisible = 'display:none' : $isVisible
                                = 'display:flex';
                                @endphp
                                @php
                                $show = $isVisible == 'display:none' ? 'visibility:hidden' : '';
                                @endphp
                                <div style="{{$show}}" class="number-input">
                                    <p style="margin-left: 15px;"></p>
                                    <button type="button"
                                        onclick="increaseValue(this,'{{route('edit.carts',['id' => $order->c_ID])}}')"><b>+</b></button>
                                    <form action="{{route('edit.carts',['id' => $order->c_ID])}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input class="input-number number"
                                            onchange="insert(this,'{{route('edit.carts',['id' => $order->c_ID])}}')"
                                            type="number" name="amounts" value="{{ $order->c_amount}}" min="0">
                                    </form>
                                    <button type="button"
                                        onclick="decreaseValue(this,'{{route('edit.carts',['id' => $order->c_ID])}}')"><b>-</b></button>
                                </div>
                                <div class="card-action" style="display: flex;width: 100%;justify-content: flex-end;">
                                    <a onclick="updateAmount(this)" href="#!"
                                        style="margin-left: auto;margin-right: 0; {{$isVisible}}">هەڵگرتن</a>
                                    <form style="display:flex" action="{{route('order.delete',['id'=>$order->c_ID])}}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a onclick="submitForm(this);" href="#!">سڕینەوە</a>
                                        <a style="{{$isVisible}}" href="/item/{{$order->item->ip_ID}}">بینین</a>
                                    </form>
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


        </div>

    </div>

</div>
<script>
    function submitForm(x){
    var form = x.parentElement;
    form.submit();
}
function submitMe(){
    var form = document.getElementById('form-to-submit');
    form.submit();
}
    function updateAmount(x){
    var form = x.parentElement.parentElement.querySelector('.number-input form');
    form.submit();
}

function increaseValue(x,link) {
        var value = parseInt(x.parentElement.querySelector('form .input-number').value);
        value = isNaN(value) ? 0 : value;
        value++;
        x.parentElement.querySelector('form .input-number').value = value;

        var p = x.parentElement.parentElement.querySelector('.card-content p');
        
        var pp = x.parentElement.parentElement.parentElement.parentElement.parentElement;
        
        if(pp.className != 'row'){
            pp = pp.querySelector('.collapsible-header .card-stacked .card-content p'); 
        }
        $.ajax({
        method: "PUT",
        url: link,
        data: {
        "_token": "{{ csrf_token() }}",
        "amounts" : value
        },
        success:function (msg) {
            p.innerHTML  = 'IQD '+numberWithCommas(msg.value);
            if(pp.className != 'row'){
                pp.innerHTML = 'IQD '+numberWithCommas(msg.all);
            }
            document.getElementById('all-item-price').innerHTML =numberWithCommas(msg.all_order.all) +' IQD';
            document.getElementById('all-item-amount').innerHTML = msg.all_order.amount;
             
        },
        error:function (jqXHR, textStatus, errorThrown) {
            
               alert('Data Not Updated !!!'); 
            
        },
        });
    }
    function decreaseValue(x,link) {
        var value = parseInt(x.parentElement.querySelector('form .input-number').value);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        x.parentElement.querySelector('form .input-number').value = value;
        var p = x.parentElement.parentElement.querySelector('.card-content p');



        var pp = x.parentElement.parentElement.parentElement.parentElement.parentElement;
        
        if(pp.className != 'row'){
            pp = pp.querySelector('.collapsible-header .card-stacked .card-content p'); 
        }
      
        $.ajax({
        method: "PUT",
        url: link,
        data: {
        "_token": "{{ csrf_token() }}",
        "amounts" : value
        },
        success:function (msg) {
            p.innerHTML  = 'IQD '+numberWithCommas(msg.value);
            if(pp.className != 'row'){
                pp.innerHTML = 'IQD '+numberWithCommas(msg.all);
            }             
            document.getElementById('all-item-price').innerHTML =numberWithCommas(msg.all_order.all) +' IQD';
            document.getElementById('all-item-amount').innerHTML = msg.all_order.amount;
        },
        error:function (jqXHR, textStatus, errorThrown) {
            
               alert('Data Not Updated !!!'); 
            
        },
        });
    }
    function insert(inputs,link) {
        var p = inputs.parentElement.parentElement.parentElement.querySelector('.card-content p');
        var pp = inputs.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
        if(pp.className != 'row'){
            pp = pp.querySelector('.collapsible-header .card-stacked .card-content p'); 
        }
        $.ajax({
        method: "PUT",
        url: link,
        data: {
        "_token": "{{ csrf_token() }}",
        "amounts" : inputs.value
        },
        success:function (msg) {
           p.innerHTML  = 'IQD '+numberWithCommas(msg.value);
           if(pp.className != 'row'){
                pp.innerHTML = 'IQD '+numberWithCommas(msg.all);
            }   
            document.getElementById('all-item-price').innerHTML =numberWithCommas(msg.all_order.all) +' IQD';
            document.getElementById('all-item-amount').innerHTML = msg.all_order.amount;
        },
        error:function (jqXHR, textStatus, errorThrown) {
            
               alert('Data Not Updated !!!'); 
            
        },
        });
    }

    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
    function changeType(check) {
        var ch = check.checked ? "{{route('submit.order',['type'=>1])}}" :  "{{route('submit.order',['type'=>0])}}";
        var x = document.getElementById('typetogo');
        x.href = ch;
        console.log(x.href);
    }
</script>



@endsection