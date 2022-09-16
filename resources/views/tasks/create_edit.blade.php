@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form class="row g-3 needs-validation" novalidate method="post" action="{{empty($task) ?  route('tasks.store') :  route('tasks.update', $task->id) }}" >
                    @if(!empty($task))
                        @method('PUT')
                    @endif
                        @csrf
                    <div class="mb-3">
                        <label id="title" class="form-label">Title</label>
                        <input type="text" class="form-control title" name="title" required  placeholder="Enter Title" value="{{ (!empty($task)) ? $task->title : null  }}">
                        @if($errors->has('title'))
                            <div class="error text-danger">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label id="title" class="form-label">Assign TO</label>
                        <select class="form-select"  name="assign_to" required>
                            <option value="">Select Assign</option>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}"  @if(!empty($task) && $id == $task->assign_to) selected @endif >{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label id="title" class="form-label">Status</label>
                        <select class="form-select"  name="status">
                            @foreach($task_status as $id => $name)
                                <option value="{{ $id }}" @if(!empty($task) && $id == $task->status) selected @endif >{{ strtoupper( str_replace('_', ' ', $name) ) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ (!empty($task)) ? $task->description : null  }}</textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Submit Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 @endsection
