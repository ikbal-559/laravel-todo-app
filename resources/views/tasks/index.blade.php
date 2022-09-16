@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                    @foreach($tasks as $task)
                        <div class="card mb-1" >
                            <div class="card-body">
                                <h5 class="card-title">{{ $task->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $task->created }}</h6>
                                <p class="card-text">{{ substr($task->description , 0, 150) }}</p>

                            </div>
                            <div class="card-footer bg-white ">
                                <ul class="nav nav-pills card-header-pills">
                                    <li class="nav-item">
                                        <a class="nav-link text-success" javascript:void(0) >Assigned To:  {{ $task->assignTo->name }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-success" javascript:void(0)>Created By:  {{ $task->createdBy->name }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-dark" javascript:void(0)>Status:  {{ strtoupper( str_replace('_', ' ', $task_status[$task->status] )) }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tasks.show', $task->id) }}"><i class="fa fa-eye"></i> Details</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                     @endforeach

                        <div class="d-flex justify-content-center">
                            {!! $tasks->links() !!}
                        </div>

            </div>
        </div>
    </div>
@endsection
