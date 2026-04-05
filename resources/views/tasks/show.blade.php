@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Détails de la tâche</h1>
        <a href="{{ route('tasks.index') }}"
            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
            Retour
        </a>
    </div>

    <div class="mb-4">
        <label class="block text-gray-500 text-sm mb-1">Titre</label>
        <p class="text-gray-800 font-medium text-lg">{{ $task->title }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-500 text-sm mb-1">Description</label>
        <p class="text-gray-800">{{ $task->description ?? 'Aucune description' }}</p>
    </div>

    <div class="mb-4">
        <label class="block text-gray-500 text-sm mb-1">Statut</label>
        @if($task->status == 'todo')
            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">À faire</span>
        @elseif($task->status == 'in_progress')
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">En cours</span>
        @else
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Terminé</span>
        @endif
    </div>

    <div class="mb-4">
        <label class="block text-gray-500 text-sm mb-1">Priorité</label>
        @if($task->priority == 'low')
            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">Basse</span>
        @elseif($task->priority == 'medium')
            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Moyenne</span>
        @else
            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Haute</span>
        @endif
    </div>

    <div class="mb-6">
        <label class="block text-gray-500 text-sm mb-1">Date limite</label>
        <p class="text-gray-800">{{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Aucune date limite' }}</p>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('tasks.edit', $task->id) }}"
            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Modifier
        </a>
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600"
                onclick="return confirm('Supprimer cette tâche ?')">
                Supprimer
            </button>
        </form>
    </div>

</div>
@endsection
