<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create() {
        return view('tasks.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:low,medium,high',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche créée avec succès!');
    }


    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }



    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'status' => 'required|in:todo,in_progress,done',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche mise à jour avec succès!');
    }

    
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche supprimée avec succès!');
    }
}