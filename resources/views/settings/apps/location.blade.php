@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Location</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.location.index')}}">Location</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <!-- Form -->
    @if (isset($edit))

    <div class="col-lg-6">
        <form action="{{route('dashboard.location.update',["id"=>$edit->l_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="location">Name : {{$edit->l_name}}</label>
                <input type="text" value="{{$edit->l_name}}" class="form-control" name="location" id="location"
                    placeholder="Location">
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" {{ $edit->l_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                    id="customCheck" name="state">
                <label class="custom-control-label" for="customCheck">State</label>
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Edit Location" />
        </form>
    </div>
    @else
    <div class="col-lg-6">
        <form action="{{route('dashboard.location.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="location">Name</label>
                <input type="text" class="form-control" name="location" id="location" placeholder="Location">
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New Location" />
        </form>
    </div>
    @endif

    <div class="col-lg-6">
        <h6 class="text-secondary ">Locations</h6>
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
                    @forelse ($location as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->l_ID}}</td>
                        <td>{{$item->l_name}}</td>
                        @if ($item->l_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.location.update',["id"=>$item->l_ID , "type" => 1])}}"
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
                                <form action="{{route('dashboard.location.update',["id"=>$item->l_ID , "type" => 1])}}"
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
                                    <a class="dropdown-item" href="{{route('dashboard.location.edit',$item->l_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.location.destroy',$item->l_ID)}}" method="POST">
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