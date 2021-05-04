@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">User Dashboard</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.user.index')}}">User</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <!-- Form -->
    @if (isset($edit))
    <!-- Modal Start-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h4>Change password</h4>

                </div>
                <form action="{{route('dashboard.user.update',["id"=>$edit->ad_ID , "type" => 2])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="new_password">New Password: </label>
                            <input type="password" class="form-control" name="new_password" id="new_password"
                                placeholder="New Password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password: </label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                                placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mt-5 float-right"
                            data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary mt-5 float-left" value="Change" />

                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Modal End-->
    <div class="col-lg-6">
        <form action="{{route('dashboard.user.update',["id"=>$edit->ad_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <div class="form-group">
                    <label for="firstname">Firstname: </label>
                    <input type="text" value="{{ $edit->ad_first_name }}" class="form-control" name="firstname"
                        id="firstname" placeholder="Firstname" required>
                </div>
                <div class="form-group">
                    <label for="middlename">Middlename: </label>
                    <input type="text" value="{{ $edit->ad_middle_name }}" class="form-control" name="middlename"
                        id="middlename" placeholder="Middlename" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Lastname: </label>
                    <input type="text" value="{{ $edit->ad_last_name}}" class="form-control" name="lastname"
                        id="lastname" placeholder="Lastname" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone: </label>
                    <input type="phone" value="{{ $edit->ad_phone }}" class="form-control" name="phone" id="phone"
                        placeholder="Phone" required>
                </div>
                <div class="form-group">
                    <label for="username">Username: </label>
                    <input type="text" value="{{ $edit->ad_username }}" class="form-control" name="username"
                        id="username" placeholder="Username" required>
                </div>
                <div class="form-group" id="role">
                    <label for="role">Role:</label>
                    <select name="role" class="custom-select mb-3">
                        @if ($edit->ad_role == 1)
                        <option selected value="1">Admin</option>
                        <option value="0">User</option>
                        @else
                        <option value="1">Admin</option>
                        <option selected value="0">User</option>
                        @endif
                    </select>
                </div>
                <div class="form-group" id="location">
                    <label for="usr">Locations:</label>
                    <select name="locations" class="custom-select mb-3">
                        @forelse ($locations as $location)
                        <option {{ $location->l_ID == $edit->ad_l_ID ? 'selected' : '' }} value="{{$location->l_ID}}">
                            {{$location->l_name}}</option>
                        @empty
                        <script>
                            document.getElementById('location').remove();
                        </script>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" {{ $edit->ad_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                    id="customCheck" name="state">
                <label class="custom-control-label" for="customCheck">State</label>
            </div>

            <button type="button" class="btn btn-primary mt-5 float-left" data-toggle="modal"
                data-target="#myModal">Change Password</button>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Edit User" />
        </form>
    </div>
    @else
    <div class="col-lg-6">
        <form action="{{route('dashboard.user.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <div class="form-group">
                    <label for="firstname">Firstname: </label>
                    <input type="text" value="{{ old('firstname') }}" class="form-control" name="firstname"
                        id="firstname" placeholder="Firstname" required>
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
                    <label for="password">Password: </label>
                    <input type="password" value="{{ old('password') }}" class="form-control" name="password"
                        id="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password: </label>
                    <input type="password" value="{{ old('confirm_password') }}" class="form-control"
                        name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div class="form-group" id="role">
                    <label for="role">Role</label>
                    <select name="role" class="custom-select mb-3">
                        <option value="1">Admin</option>
                        <option value="0">User</option>
                    </select>
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
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New User" />
        </form>
    </div>
    @endif

    <div class="col-lg-6">
        <h6 class="text-secondary ">User</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>State</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->ad_first_name . ' ' .$item->ad_last_name}}</td>
                        <td>{{$item->ad_role == 1 ? 'Admin' : 'User'}}</td>
                        @if ($item->ad_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.user.update',["id"=>$item->ad_ID , "type" => 1])}}"
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
                                <form action="{{route('dashboard.user.update',["id"=>$item->ad_ID , "type" => 1])}}"
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
                                    <a class="dropdown-item"
                                        href="{{route('dashboard.user.edit',$item->ad_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.user.destroy',$item->ad_ID)}}" method="POST">
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