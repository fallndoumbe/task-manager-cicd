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

    return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succés!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
   {
         $task = Task::findOrFail($id);
         return view('tasks.show', compact('task'));
    }

    /**
 * Show the form for editing the specified resource.
 */
public function edit(string $id)
{
    $task = Task::findOrFail($id);
    return view('tasks.edit', compact('task'));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $task = Task::findOrFail($id);

    $request->validate([
        'title' => 'required|max:255',
        'status' => 'required|in:todo,in_progress,done',
        'priority' => 'required|in:low,medium,high',
    ]);

    $task->update($request->all());

    return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès!');
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    $task = Task::findOrFail($id);
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès!');
}
}
