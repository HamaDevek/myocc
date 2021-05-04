@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">User Settings</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.management.index')}}">User</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <div class=" col-lg-12">
        <h6 class="text-secondary ">Users</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Location</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($accounts as $key=>$value)
                    <tr>
                        <td><img src="{{secure_asset('storage/'.$value->a_image)}}" height="50px" width="50px"
                                class="img-thumbnail" alt="..."></td>
                        <td>
                            {{$value->a_name}}
                        </td>
                        <td>
                            {{$value->a_phone}}
                        </td>
                        <td>
                            {{$value->a_address}}
                        </td>
                        <td>
                            {{$value->location->l_name}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark  btn-sm dropdown-toggle"
                                    data-toggle="dropdown">
                                    @php
                                    $active = $value->a_state == 0 ? 'Pendding' : (
                                    $value->a_state == 1 ? 'Active' : 'Deactive'
                                    )

                                    @endphp
                                    {{ $active}}
                                </button>
                                <div class="dropdown-menu">
                                    <form method="POST"
                                        action="{{route('dashboard.management.update',['management'=>$value->a_ID])}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="state" value="1">
                                        <button class="dropdown-item" type="submit">Active</button>
                                    </form>
                                    <form method="POST"
                                        action="{{route('dashboard.management.update',['management'=>$value->a_ID])}}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="state" value="2">
                                        <button class="dropdown-item" type="submit">Deactive</button>
                                    </form>
                                </div>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection