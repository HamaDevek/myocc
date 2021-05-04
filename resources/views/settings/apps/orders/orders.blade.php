@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Orders</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.orders.index')}}">Orders</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <div class="col-lg-12">
        <h6 class="text-secondary ">Orders</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Address From</th>
                        <th>Address To</th>
                        <th>Price</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $key=>$item)
                    <tr>
                        <td>{{++$key}}</td>
                        <td><a
                                href="{{route('dashboard.orders.show',['order'=>$item->oi_ID])}}">{{$item->oi_name_from}}</a>
                        </td>
                        <td>{{$item->owner->a_name}}</td>
                        <td>{{$item->oi_address_from}}</td>
                        <td>{{$item->oi_address_to}}</td>
                        <td>{{number_format($item->oi_price_all)}}</td>
                        <td>

                            @php
                            $state = $item->oi_state == 3
                            ? '<p style="color: orange">Delivery</p>'
                            : ($item->oi_state == 2
                            ? '<p style="color: red">Rejected</p>'
                            : ($item->oi_state == 1 ? '<p style="color: green">Accepted</p>' : '<p style="color: blue">
                                Pendding</p>'));
                            @endphp
                            {!!$state!!}
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection