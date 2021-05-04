@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Dashboard</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.dashboard.index')}}">Dashboard</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <div class="col-lg-6">
        d
    </div>
    <div class="col-lg-6">
        <h6 class="text-secondary ">Active Request Delivery</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Taxi</th>
                        <th>Taxi Phone</th>
                        <th>Request name</th>
                        <th>Time to Delivery</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taxi as $key=>$value)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$value->t_first_name}} {{$value->t_middle_name}}</td>
                        <td>{{$value->t_phone}}</td>
                        <td><a
                                href="{{route('dashboard.orders.show',['order'=>$value->oi_ID])}}">{{$value->oi_name_from}}</a>
                        </td>
                        <td>{{$value->oi_to_date}} {{$value->oi_to_time}} </td>
                        <td>
                            <div style="display: flex">
                                <form method="POST"
                                    action="{{route('dashboard.orders.reject_delivery',['order'=>$value->oi_ID,'taxi' => $value->t_ID])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mr-2"><i class="fas fa-times-circle"></i></button>
                                </form>
                                <form method="POST"
                                    action="{{route('dashboard.orders.accept_delivery',['order'=>$value->oi_ID,'taxi' => $value->t_ID])}}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-check-circle"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection