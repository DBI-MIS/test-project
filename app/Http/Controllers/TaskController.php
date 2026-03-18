<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\TaskType;
use App\Models\User;

class TaskController extends Controller
{
    
    public function index()
    {
        $perpage = request('per_page', 4);
        $taskTypes = TaskType::with('tasks')->get();
        $taskQuery  = Task::with([
                'creator',
                'type.tasks', // bring back related tasks
                'users'
                ])->orderBy('created_at', 'desc');

        if (request()->filled('search')) {
            $searchTerm = '%' . request()->query('search') . '%';
            $taskQuery->where('name', 'like', $searchTerm);
        }

        $tasks = $taskQuery->paginate($perpage);

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'taskTypes' => $taskTypes,
        ]);

    }

    public function create()
    {
        return Inertia::render('Tasks/Create', [
            'types' => TaskType::all(),
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $creator = auth()->user();

        $data = $request->validate([
            'name' => 'required',
            'number' => 'required|integer',
            'description' => 'required',
            'task_type_id' => 'required|exists:task_types,id',
            'users' => 'array'
        ]);

        // create task
        $task = $creator->tasks()->create($data);

        // attach assigned users
        if ($request->has('users')) {
            $task->users()->attach($request->users);
        }

        return to_route('tasks.index');
    }

    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', [
            'task' => $task->load(['type', 'users']), 
            'types' => TaskType::all(),
            'users' => User::all() 
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'number' => 'required|integer',
            'task_type_id' => 'required|exists:task_types,id',
            'users' => 'array' 
        ]);

        $task->update($data);

        // sync users (replace assignments)
        $task->users()->sync($request->users ?? []);

        return to_route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return to_route('tasks.index');
    }
}