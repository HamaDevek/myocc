@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Orders Show</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.orders.index')}}">Orders</a></li>
        <li class="breadcrumb-item">{{$orders->oi_name_from}}</li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <div class="col-lg-6">
        <div class="row">
            <div class="border rounded p-4 col-lg-12">
                <h4><b>Order name </b>: {{$orders->oi_name_from}}</h4>
                <hr class="mt-4">
                <p><b>Order owner </b>: {{$orders->owner->a_name}}</p>
                <p><b>Order owner </b>: {{$orders->owner->a_phone}}</p>
                <p><b>Order Location </b>: {{$orders->location->l_name}}</p>
                <p><b>Recipient Phone </b>: {{$orders->oi_phone_from}}</p>
                <p><b>Recipient Address </b>: {{$orders->oi_address_from}}</p>
                @if ($orders->oi_type == 1)
                <p><b>Billed Name </b>: {{$orders->oi_name_to}}</p>
                <p><b>Billed Phone </b>: {{$orders->oi_phone_to}}</p>
                <p><b>Billed Address </b>: {{$orders->oi_address_to}}</p>
                <p><b>Type Order </b>: Other </p>
                @else
                <p><b>Type Order </b>: Myself </p>
                @endif
                <p><b>Delivery Date </b>: {{date('Y-m-d l',strtotime($orders->oi_to_date))}}</p>
                <p><b>Delivery Time </b>: {{date('h:i a',strtotime($orders->oi_to_time))}}</p>
                <p><b>State </b>: <span style="color: red">Rejected</span></p>
            </div>
        </div>

    </div>
    <div class="col-lg-6">
        <div class="row">
            <div class=" mt-3 col-lg-12">
                <div style="display: flex;justify-content: space-between">
                    <h6 class="text-secondary ">Orders</h6>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table  table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $price_all = 0;
                            $amount_all = 0;
                            @endphp
                            @forelse ($orders->ordered as $key=>$item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$item->item->ip_name}}</td>
                                <td>{{$item->item->ip_price}}</td>
                                <td>{{$item->item->type->tp_name}}</td>
                                <td>
                                    {{$item->o_amount}}
                                    @php
                                    $price_all = $price_all + $item->item->ip_price;
                                    $amount_all = $amount_all + $item->o_amount;
                                    @endphp
                                </td>
                                <td>

                                </td>

                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>:{{$price_all }}</td>
                                <td></td>
                                <td>:{{$amount_all}}</td>
                                <td></td>


                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection