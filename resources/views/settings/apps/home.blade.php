@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Home</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.home.index')}}">Home</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    {{-- Add Photo Banner --}}
    <div class="col-lg-6">
        <form action="{{route('dashboard.home.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <div class="form-group">
                    <label for="title">Title: </label>
                    <input type="text" value="{{ old('title') }}" class="form-control" name="title" id="title"
                        placeholder="Title" required>
                </div>
                <div class="form-group">
                    <label for="subtitle">Subtitle: </label>
                    <input type="text" value="{{ old('subtitle') }}" class="form-control" name="subtitle" id="subtitle"
                        placeholder="Subtitle" required>
                </div>
                <div class="form-group" id="role">
                    <label for="clss">Direction</label>
                    <select name="clss" class="custom-select mb-3">
                        <option value="1">Right</option>
                        <option value="0">Left</option>
                    </select>
                </div>
                <div class="mt-3 form-group">
                    <input name="imgs" type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <input type="submit" class="btn btn-success mb-3 float-right" value="add Image">
            </div>
        </form>
        <div class="mt-5">
                <h6 class="text-secondary ">Banner</h6>
                <hr>
                <div class="table-responsive">
                    <table class="table  table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Side</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($home as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{$item->id}}</td>
                                <td>{!!$item->title!!}</td>
                                <td>
                                    <div style="height:40px;width:40px">
                                        <a href="{{secure_asset('storage/'.$item->image)}}"><img
                                                src="{{secure_asset('storage/'.$item->image)}}" class="img-thumbnail"
                                                alt=""></a>
                                    </div>
                                </td>
                                <td>{{ $item->class == 'left-align' ? 'left' : 'rigth'}}</td>
                                <td>
                                    <div class="btn-group">
                                        <form action="{{route('dashboard.home.destroy',$item->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-sm btn-danger" value="delete" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>

    </div>
    {{-- Edit Photo --}}
    <div class="col-lg-6">
        
        <form action="{{route('dashboard.home.store_extra')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <div class="form-group">
                    <label for="ceneter_title">Center Title: </label>
                    <input type="text" value="{{ $extra->title }}" class="form-control" name="ceneter_title"
                        id="ceneter_title" placeholder="Ceneter Title" required>
                </div>
                <div class="mt-3 form-group">
                    <input name="imgss" type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <input type="submit" class="btn btn-success mb-3 float-right" value="Edit Image">
            </div>
        </form>
        <a href="{{ secure_asset('storage/'. $extra->image)}}" target="_blank" rel="noopener noreferrer"><img
                src="{{ secure_asset('storage/'. $extra->image)}}" alt="" style="width:200px;height:200px;"></a>
    </div>
</div>
@endsection