@extends('settings.layout.app',['title' => 'Dashboard'])
@section('title')
<div class="card-header bg-white">
    <h3 class="pt-3">Q & A</h3>
    <ul class="breadcrumb  bg-white p-0 pt-3 ">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item">Settings</li>
        <li class="breadcrumb-item active"><a href="{{route('dashboard.Q&A.index')}}">Q & A</a></li>
    </ul>
</div>
@endsection
@section('content')
@include('settings.layout.messages')
<div class="row">
    @if (isset($edit))
    {{-- EDIT --}}
    <div class="col-lg-6">
        <form action="{{route('dashboard.Q&A.update',['id'=>$edit->qa_ID,'type' =>0])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <div class="form-group">
                    <label for="question">Question: </label>
                    <input type="text" value="{{$edit->qa_q}}" class="form-control" name="question" id="question"
                        placeholder="Question" required>
                </div>
                <div class="form-group">
                    <label for="answer">Answer: </label>
                    <textarea class="form-control summernote" name="answer" placeholder="Answer" rows="5"
                        id="answer">{{$edit->qa_a}}</textarea>
                </div>
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" {{ $edit->qa_state == 1 ? 'Checked' : '' }} class="custom-control-input"
                        id="customCheck" name="state">
                    <label class="custom-control-label" for="customCheck">State</label>
                </div>
                <input type="submit" class="btn btn-success mb-3 float-right" value="Change Q&A">
            </div>
        </form>
    </div>
    @else
    {{-- INSERT --}}
    <div class="col-lg-6">
        <form action="{{route('dashboard.Q&A.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <div class="form-group">
                    <label for="question">Question: </label>
                    <input type="text" value="" class="form-control" name="question" id="question"
                        placeholder="Question" required>
                </div>
                <div class="form-group">
                    <label for="answer">Answer: </label>
                    <textarea class="form-control summernote" name="answer" placeholder="Answer" rows="5"
                        id="answer"></textarea>
                </div>
                <input type="submit" class="btn btn-success mb-3 float-right" value="Add Q&A">
            </div>
        </form>
    </div>

    @endif
    <div class="col-lg-6">
        <h6 class="text-secondary ">Q&A</h6>
        <hr>
        <div class="table-responsive">
            <table class="table  table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Question</th>
                        <th>State</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($qanda as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$item->qa_ID}}</td>
                        <td>{{$item->qa_q}}</td>
                        @if ($item->qa_state == 1)
                        <td>
                            <div class="btn-group">
                                <form action="{{route('dashboard.Q&A.update',['id'=>$item->qa_ID,'type' =>1])}}"
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
                                <form action="{{route('dashboard.Q&A.update',['id'=>$item->qa_ID,'type' =>1])}}"
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
                                        href="{{route('dashboard.Q&A.edit',$item->qa_ID)}}">Modify</a>
                                    <form action="{{route('dashboard.Q&A.destroy',$item->qa_ID)}}" method="POST">
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
</div>
@endsection