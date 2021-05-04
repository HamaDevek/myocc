@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Type</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.type.index')}}">Type</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <!-- Form -->
    @if (isset($edit))

    <div class="col-lg-6">
        <form action="{{route('dashboard.type.update',["id"=>$edit->tp_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="type">Name : {{$edit->tp_name}}</label>
                <input type="text" value="{{$edit->tp_name}}" class="form-control" name="type" id="type"
                    placeholder="Type name">
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" {{ $edit->tp_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                    id="customCheck" name="state">
                <label class="custom-control-label" for="customCheck">State</label>
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Edit Type" />
        </form>
    </div>
    @else
    <div class="col-lg-6">
        <form action="{{route('dashboard.type.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="type">Name :</label>
                <input type="text" class="form-control" name="type" id="type" placeholder="Type name">
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New Type" />
        </form>
    </div>
    @endif

    <div class="col-lg-6">
        <h6 class="text-secondary ">Type</h6>
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
                    @forelse ($type as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->tp_ID}}</td>
                        <td>{{$item->tp_name}}</td>
                        @if ($item->tp_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.type.update',["id"=>$item->tp_ID , "type" => 1])}}"
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
                                <form action="{{route('dashboard.type.update',["id"=>$item->tp_ID , "type" => 1])}}"
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
                                    <a class="dropdown-item" href="{{route('dashboard.type.edit',$item->tp_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.type.destroy',$item->tp_ID)}}" method="POST">
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