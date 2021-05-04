@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Shop</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.shop.index')}}">Shop</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')

<div class="row">
    <!-- Form -->
    @if (isset($edit))
    @include('settings.apps.models.shop')
    <div class="col-lg-6">
        <form action="{{route('dashboard.shop.update',["id"=>$edit->sh_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="shop_name">Shop name: </label>
                <input type="text" value="{{$edit->sh_name}}" class="form-control" name="shop_name" id="shop_name"
                    placeholder="Shop name" required>
            </div>
            <div class="form-group">
                <label for="owner_name">Owner name: </label>
                <input type="text" value="{{$edit->sh_owner}}" class="form-control" name="owner_name" id="owner_name"
                    placeholder="Owner name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone: </label>
                <input type="phone" value="{{$edit->sh_phone}}" class="form-control" name="phone" id="phone"
                    placeholder="Phone" required>
            </div>
            <div class="form-group" id="location">
                <label for="usr">Locations</label>
                <select name="locations" class="custom-select mb-3">
                    @forelse ($locations as $location)
                    <option {{ $location->l_ID == $edit->sh_l_ID ? 'selected' : '' }} value="{{$location->l_ID}}">
                        {{$location->l_name}}</option>
                    @empty
                    <script>
                        document.getElementById('location').remove();
                    </script>
                    @endforelse
                </select>
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" {{ $edit->sh_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                    id="customCheck" name="state">
                <label class="custom-control-label" for="customCheck">State</label>
            </div>
            <input type="submit" class="btn btn-success float-right" value="Edit shop" />
            <button type="button" data-toggle="modal" data-target="#schedule_add" class="btn btn-warning">Schedule</button>
        </form>
    </div>
    @else
    <div class="col-lg-6">
        <form action="{{route('dashboard.shop.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="shop_name">Shop name: </label>
                <input type="text" value="{{ old('shop_name') }}" class="form-control" name="shop_name" id="shop_name"
                    placeholder="Shop name" required>
            </div>
            <div class="form-group">
                <label for="owner_name">Owner name: </label>
                <input type="text" value="{{ old('owner_name') }}" class="form-control" name="owner_name"
                    id="owner_name" placeholder="Owner name" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone: </label>
                <input type="phone" value="{{ old('phone') }}" class="form-control" name="phone" id="phone"
                    placeholder="Phone" required>
            </div>
            <div class="form-group" id="location">
                <label for="usr">Locations</label>
                <select name="locations" class="custom-select mb-3">
                    @forelse ($locations as $location)
                    <option value="{{$location->l_ID}}">{{$location->l_name}}</option>
                    @empty
                    <script>
                        document.getElementById('location').remove();
                    </script>
                    @endforelse
                </select>
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New Shop" />
        </form>
    </div>
    @endif

    <div class="col-lg-6">
        <h6 class="text-secondary ">Shops</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>State</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shop as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->sh_ID}}</td>
                        <td>{{$item->sh_name}}</td>
                        <td>{{$item->sh_phone}}</td>
                        @if ($item->sh_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.shop.update',["id"=>$item->sh_ID , "type" => 1])}}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" class="btn btn-sm btn-danger" value="Disable" />
                                </form>
                            </div>
                        </td>
                        @else
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.shop.update',["id"=>$item->sh_ID , "type" => 1])}}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" class="btn btn-sm btn-primary" value="Enable" />
                                </form>
                            </div>
                        </td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark  btn-sm dropdown-toggle"
                                    data-toggle="dropdown">
                                    Options
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('dashboard.shop.edit',$item->sh_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.shop.destroy',$item->sh_ID)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger dropdown-item" value="Delete" />
                                    </form>
                                    
                                </div>
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>

    </script>
    @endsection