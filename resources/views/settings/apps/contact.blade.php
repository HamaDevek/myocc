@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Contact As</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.contact.index')}}">Contact</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    <div class="col-lg-6">
        <form action="{{route('dashboard.contact.update',['contact'=>1])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <div class="form-group">
                    <label for="phone">Phone: </label>
                    <input type="text" value="{{$contact->con_phone}}" class="form-control" name="phone" id="phone"
                        placeholder="Phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" value="{{$contact->con_email}}" class="form-control" name="email" id="email"
                        placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address: </label>
                    <textarea class="form-control summernote" name="address" placeholder="Address" rows="5"
                        id="address">{{ $contact->con_address }}</textarea>
                </div>
                <input type="submit" class="btn btn-success mb-3 float-right" value="Change Contact">
            </div>
        </form>
    </div>
    <div class="col-lg-6">

    </div>
</div>
@endsection