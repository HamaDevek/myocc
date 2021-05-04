@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Taxi</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.taxi.index')}}">Taxi</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')

<div class="row">
    <!-- Form -->
    @if (isset($edit))
    @include('settings.apps.models.taxi')
    <div class="col-lg-6">
        <form action="{{route('dashboard.taxi.update',["id"=>$edit->t_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="firstname">Firstname: </label>
                <input type="text" value="{{$edit->t_first_name}}" class="form-control" name="firstname" id="firstname"
                    placeholder="Firstname" required>
            </div>
            <div class="form-group">
                <label for="middlename">Middlename: </label>
                <input type="text" value="{{$edit->t_middle_name}}" class="form-control" name="middlename"
                    id="middlename" placeholder="Middlename" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname: </label>
                <input type="text" value="{{$edit->t_last_name}}" class="form-control" name="lastname" id="lastname"
                    placeholder="Lastname" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone: </label>
                <input type="phone" value="{{$edit->t_phone}}" class="form-control" name="phone" id="phone"
                    placeholder="Phone" required>
            </div>
            <div class="form-group">
                <label for="carnumber">Car number: </label>
                <input type="number" value="{{$edit->t_car_ID}}" class="form-control" name="car_number" id="carnumber"
                    placeholder="Car number" required>
            </div>
            <div class="form-group">
                <label for="carmodel">Car model: </label>
                <input type="text" value="{{$edit->t_car_model}}" class="form-control" name="car_model" id="carmodel"
                    placeholder="Car model" required>
            </div>

            <div class="form-group" id="location">
                <label for="usr">Locations</label>
                <select name="locations" class="custom-select mb-3">
                    @forelse ($locations as $location)
                    <option {{ $location->l_ID == $edit->t_l_ID ? 'selected' : '' }} value="{{$location->l_ID}}">
                        {{$location->l_name}}</option>
                    @empty
                    <script>
                        document.getElementById('location').remove();
                    </script>
                    @endforelse
                </select>
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" {{ $edit->t_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                    id="customCheck" name="state">
                <label class="custom-control-label" for="customCheck">State</label>
            </div>
            <input type="submit" class="btn btn-success float-right" value="Edit Taxi" />
            <button type="button" data-toggle="modal" data-target="#schedule_add" class="btn btn-warning">Schedule</button>
        </form>
    </div>
    @else
    <div class="col-lg-6">
        <form action="{{route('dashboard.taxi.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="firstname">Firstname: </label>
                <input type="text" value="{{ old('firstname') }}" class="form-control" name="firstname" id="firstname"
                    placeholder="Firstname" required>
            </div>
            <div class="form-group">
                <label for="middlename">Middlename: </label>
                <input type="text" value="{{ old('middlename') }}" class="form-control" name="middlename"
                    id="middlename" placeholder="Middlename" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname: </label>
                <input type="text" value="{{ old('lastname') }}" class="form-control" name="lastname" id="lastname"
                    placeholder="Lastname" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone: </label>
                <input type="phone" value="{{ old('phone') }}" class="form-control" name="phone" id="phone"
                    placeholder="Phone" required>
            </div>
            <div class="form-group">
                <label for="carnumber">Car number: </label>
                <input type="number" value="{{ old('car_number') }}" class="form-control" name="car_number"
                    id="carnumber" placeholder="Car number" required>
            </div>
            <div class="form-group">
                <label for="carmodel">Car model: </label>
                <input type="text" value="{{ old('car_model') }}" class="form-control" name="car_model" id="carmodel"
                    placeholder="Car model" required>
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
            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New Taxi" />
        </form>
    </div>
    @endif

    <div class="col-lg-6">
        <h6 class="text-secondary ">Taxi</h6>
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
                    @forelse ($taxi as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->t_ID}}</td>
                        <td>{{$item->t_first_name . ' ' .$item->t_last_name}}</td>
                        <td>{{$item->t_phone}}</td>
                        @if ($item->t_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.taxi.update',["id"=>$item->t_ID , "type" => 1])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" class="btn btn-sm btn-danger" value="Disable" />
                                </form>
                            </div>
                        </td>
                        @else
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.taxi.update',["id"=>$item->t_ID , "type" => 1])}}" method="POST">
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
                                    <a class="dropdown-item" href="{{route('dashboard.taxi.edit',$item->t_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.taxi.destroy',$item->t_ID)}}" method="POST">
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
            <div class="mb-5"></div>
        </div>
    </div>
    <script>

    </script>
    @endsection