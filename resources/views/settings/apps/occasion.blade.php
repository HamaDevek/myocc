@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Occasion</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.occasion.index')}}">Occasion</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <!-- Form -->
    @if (isset($edit))

    <div class="col-lg-6">
        <form action="{{route('dashboard.occasion.update',["id"=>$edit->oc_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="occasion">Name : {{$edit->oc_name}}</label>
                <input type="text" value="{{$edit->oc_name}}" class="form-control" name="occasion" id="occasion"
                    placeholder="Occasion">
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" {{ $edit->oc_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                    id="customCheck" name="state">
                <label class="custom-control-label" for="customCheck">State</label>
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Edit occasion" />
        </form>
    </div>
    @else
    <div class="col-lg-6">
        <form action="{{route('dashboard.occasion.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="occasion">Name :</label>
                <input type="text" class="form-control" name="occasion" id="occasion" placeholder="Occasion">
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New Occasion" />
        </form>
    </div>
    @endif

    <div class="col-lg-6">
        <h6 class="text-secondary ">Occasions</h6>
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
                    @forelse ($occasion as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->oc_ID}}</td>
                        <td>{{$item->oc_name}}</td>
                        @if ($item->oc_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.occasion.update',["id"=>$item->oc_ID , "type" => 1])}}"
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
                                <form action="{{route('dashboard.occasion.update',["id"=>$item->oc_ID , "type" => 1])}}"
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
                                    <a class="dropdown-item" href="{{route('dashboard.occasion.edit',$item->oc_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.occasion.destroy',$item->oc_ID)}}" method="POST">
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