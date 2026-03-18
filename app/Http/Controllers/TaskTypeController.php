<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskType;
use Inertia\Inertia;

class TaskTypeController extends Controller
{
    public function index()
    {
        return Inertia::render('TaskTypes/Index', [
            'types' => TaskType::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('TaskTypes/Create');
    }

    public function edit(TaskType $taskType)
    {
        return Inertia::render('TaskTypes/Edit', [
            'type' => $taskType
        ]);
    }

    public function update(Request $request, TaskType $taskType)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $taskType->update($data);

        return to_route('task-types.index');
    }

    public function destroy(TaskType $taskType)
    {
        $taskType->delete();

        return to_route('task-types.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        TaskType::create($data);

        return to_route('task-types.index');
    }
}