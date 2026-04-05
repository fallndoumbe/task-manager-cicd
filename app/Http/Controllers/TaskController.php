<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private const STATUSES = ['todo', 'in_progress', 'done'];

    public function index(Request $request)
    {
        $query = Task::query()->orderBy('created_at', 'desc');

        $statusFilter = $request->query('status');
        if (is_string($statusFilter) && in_array($statusFilter, self::STATUSES, true)) {
            $query->where('status', $statusFilter);
        } else {
            $statusFilter = null;
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks', 'statusFilter'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès !');
    }

    public function show(string $id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    public function edit(string $id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task'));
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        $task = Task::findOrFail($id);

        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès !');
    }

    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès !');
    }
}
