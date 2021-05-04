@extends('settings.layout.app',['title' => 'Dashboard'])

@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Item</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.item.index')}}">Item</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    @if (isset($edit))
    <!-- Update -->
    @include('settings.apps.models.item')
    <div class="col-lg-6">
        <div class="d-flex justify-content-between mb-2 mt-2">
            <button type="button" data-toggle="modal" data-target="#image" class="btn btn-warning">Show
                Images</button>
            <button type="button" data-toggle="modal" data-target="#cols" class="btn btn-success">Show Colors</button>
        </div>
        <form action="{{route('dashboard.item.update',["id"=>$edit->ip_ID , "type" => 0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="item_name">Item name: </label>
                <input type="text" value="{{ $edit->ip_name }}" class="form-control" name="item_name" id="item_name"
                    placeholder="Item name" required>
            </div>
            <div class="form-group">
                <label for="item_price">Item price: </label>
                <input type="number" value="{{ $edit->ip_price }}" class="form-control" name="item_price"
                    id="item_price" placeholder="Item price" required>
            </div>
            <div class="form-group" id="types">
                <label for="usr">Types:</label>
                <select name="types" class="custom-select mb-3">
                    @forelse ($types as $type)
                    <option {{ $edit->ip_tp_ID ==  $type->tp_ID ? 'Selected' : '' }} value="{{$type->tp_ID}}">
                        {{$type->tp_name}}</option>
                    @empty
                    <script>

                    </script>
                    @endforelse
                </select>
            </div>
            <div class="form-group" id="shops">
                <label for="usr">Shops:</label>
                <select name="shops" class="custom-select mb-3">
                    @foreach ($shops as $shop)
                    <option {{ $edit->ip_sh_ID ==  $shop->sh_ID ? 'Selected' : '' }} value="{{$shop->sh_ID}}">
                        {{$shop->sh_name}}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group" id="occasion">
                <label for="usr">Occasion:</label>
                <select name="occasions" class="custom-select mb-3">
                    @foreach ($occations as $occasion)
                    <option {{ $edit->ip_oc_ID ==  $occasion->oc_ID ? 'Selected' : '' }} value="{{$occasion->oc_ID}}">
                        {{$occasion->oc_name}}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="item_desc">Item description: </label>
                <textarea class="form-control summernote" name="item_desc" placeholder="Item description" rows="5"
                    id="item_desc">{{ $edit->ip_description }}</textarea>
            </div>
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" {{ $edit->ip_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                    id="customCheck" name="state">
                <label class="custom-control-label" for="customCheck">State</label>
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Edit item" />
        </form>
    </div>
    @else
    <!-- Insert -->
    <div class="col-lg-6">
        <form action="{{route('dashboard.item.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="item_name">Item name: </label>
                <input type="text" value="{{ old('item_name') }}" class="form-control" name="item_name" id="item_name"
                    placeholder="Item name" required>
            </div>
            <div class="form-group">
                <label for="item_price">Item price: </label>
                <input type="number" value="{{ old('item_price') }}" class="form-control" name="item_price"
                    id="item_price" placeholder="Item price" required>
            </div>
            <div class="form-group" id="types">
                <label for="usr">Types:</label>
                <select name="types" class="custom-select mb-3">
                    @forelse ($types as $type)
                    <option value="{{$type->tp_ID}}">{{$type->tp_name}}</option>
                    @empty
                    <script>

                    </script>
                    @endforelse
                </select>
            </div>
            <div class="form-group" id="shops">
                <label for="usr">Shops:</label>
                <select name="shops" class="custom-select mb-3">
                    @foreach ($shops as $shop)
                    <option value="{{$shop->sh_ID}}">{{$shop->sh_name}}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group" id="occasion">
                <label for="usr">Occasion:</label>
                <select name="occasions" class="custom-select mb-3">
                    @foreach ($occations as $occasion)
                    <option value="{{$occasion->oc_ID}}">{{$occasion->oc_name}}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="item_desc">Item description: </label>
                <textarea class="form-control summernote" name="item_desc" placeholder="Item description" rows="5"
                    id="item_desc">{{ old('item_desc') }}</textarea>
            </div>
            <div class="form-group">
                <label for="">Image: </label>
                <input name="img" type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <input type="submit" class="btn btn-success mt-5 float-right" value="Add New item" />
        </form>
    </div>
    @endif

    <!-- Select -->
    <div class="col-lg-6">
        <h6 class="text-secondary ">Items</h6>
        <hr>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Type</th>
                        <th>State</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->ip_name}}</td>
                        <td>{{$item->ip_price}}</td>
                        <td>{{$item->type->tp_name}}</td>
                        @if ($item->ip_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.item.update',["id"=>$item->ip_ID , "type" => 1])}}"
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
                                <form action="{{route('dashboard.item.update',["id"=>$item->ip_ID , "type" => 1])}}"
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
                                        href="{{route('dashboard.item.edit',$item->ip_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.item.destroy',$item->ip_ID)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger dropdown-item" value="Delete" />
                                    </form>
                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#info">Information</button>
                                </div>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mb-5"></div>
        </div>
    </div>

</div>
<script>
    function col(color){
    var parent = document.getElementById('cols');
    var divtest = document.createElement("div");
    divtest.style = 'background-color:'+color+' !important;height: 40px;width: 40px';
    divtest.className = 'ml-3 mt-3';
    divtest.innerHTML = '<input type="hidden" name="colors[]" value="'+color+'" >';
    parent.appendChild(divtest);

}
</script>
@endsection