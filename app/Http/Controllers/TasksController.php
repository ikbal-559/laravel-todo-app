<?php

namespace App\Http\Controllers;

use App\Events\TaskAssignedEvent;
use App\Http\Requests\TaskRequest;
use App\Models\Task;

use App\Models\User;
use App\Services\AccessService;
use Exception;
use DB;

class TasksController extends Controller
{

    public $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->middleware('auth');
        $this->accessService = $accessService;
    }


    public function index()
    {
        return view('tasks.index', [
            'tasks' => Task::getTasks(),
            'task_status' => array_flip(config('app.task_status'))
        ]);
    }

    public function create()
    {
        return view('tasks.create_edit', [
            'users' => User::where('role', config('app.roles.user'))->pluck('name', 'id'),
            'task_status' => array_flip(config('app.task_status'))
        ]);
    }

    public function store(TaskRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->safe()->only(['title', 'description', 'assign_to']);
            $validated['created_by'] = auth()->id();
            $task = Task::create($validated);
            DB::commit();

            event(new TaskAssignedEvent(auth()->user(), $task));

            return redirect()->to(route('tasks.index'))->with('success', 'Task created successfully!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->to(route('tasks.index'))->with('error', $ex->getMessage());
        }
    }


    public function show(Task $task)
    {
        $this->checkTaskAccess($task);
        return view('tasks.show', [
            'task' => $task,
            'task_status' => array_flip(config('app.task_status'))
        ]);
    }


    public function edit(Task $task)
    {
        $this->checkTaskAccess($task);
        return view('tasks.create_edit', [
            'task' => $task,
            'users' => User::where('role', config('app.roles.user'))->pluck('name', 'id'),
            'task_status' => array_flip(config('app.task_status'))
        ]);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->checkTaskAccess($task);
        try {
            $assignChanged = ($request->assign_to != $task->assign_to) ? true : false;
            DB::beginTransaction();
            $validated = $request->safe()->only(['title', 'description', 'assign_to', 'status']);
            $task->update($validated);
            DB::commit();
            if ($assignChanged) {
                $user = User::find($request->assign_to);
                event(new TaskAssignedEvent($user, $task));
            }
            return redirect()->to(route('tasks.index'))->with('success', 'Task updated successfully!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->to(route('tasks.index'))->with('error', $ex->getMessage());
        }
    }


    public function destroy(Task $task)
    {
        $this->checkTaskAccess($task);
        try {
            DB::beginTransaction();
            if (!empty($task)) {
                $task->delete();
            }
            DB::commit();
            return redirect()->to(route('tasks.index'))->with('success', 'Task deleted successfully!');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->to(route('tasks.index'))->with('error', $ex->getMessage());
        }
    }

    private function checkTaskAccess($task)
    {
        if (!$this->accessService->hasTaskAccess($task, auth()->user())) {
            return redirect()->to(route('tasks.index'))->with('error', "You do not have access!");
        }
    }
}
