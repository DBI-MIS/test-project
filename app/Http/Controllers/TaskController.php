<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => Task::with('creator')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(Request $request)
    {
        $creator = auth()->user();
        $data = $request->validate([
            'name' => 'required',
            'number' => 'required|integer',
            'description' => 'required',
        ]);

        $creator->tasks()->create($data);

        return to_route('tasks.index');
    }

    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', [
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'number' => 'required|integer',
        ]);

        $task->update($data);

        return to_route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return to_route('tasks.index');
    }
}