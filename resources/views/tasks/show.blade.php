@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-1" >
                    <div class="card-body">
                        <h5 class="card-title">{{ $task->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $task->created }}</h6>
                        <p class="card-text">{{ $task->description  }}</p>

                    </div>
                    <div class="card-footer bg-white justify-content-between d-flex ">
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
                                <a class="nav-link" href="{{ route('tasks.edit', $task->id) }}"><i class="fa fa-pencil"></i> edit</a>
                            </li>
                            <li class="nav-item">
                                <a  data-bs-toggle="modal" data-bs-target="#taskDelete" class="nav-link"  javascript:void(0) ><i class="fa fa-trash"></i> delete</a>
                            </li>

                        </ul>
                        <a class="btn btn-sm text-primary fw-bold" href="{{ route('tasks.index') }}">View ALL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="taskDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="taskDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="row g-3 needs-validation" novalidate method="post" action="{{ route('tasks.destroy', $task->id) }}" >
                @method('DELETE')
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskDeleteLabel">Delete Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    are you sure, you want to delete this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Task Delete</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection
