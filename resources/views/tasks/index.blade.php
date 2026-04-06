@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Toutes les tâches</h1>
        <a href="{{ route('tasks.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Nouvelle tâche
        </a>
    </div>

    {{-- Filtres par statut --}}
    <div class="flex gap-2 mb-6">
        <a href="{{ route('tasks.index') }}"
            class="px-4 py-2 rounded {{ $statusFilter === null ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
            Toutes
        </a>
        <a href="{{ route('tasks.index', ['status' => 'todo']) }}"
            class="px-4 py-2 rounded {{ $statusFilter === 'todo' ? 'bg-gray-500 text-white' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
            À faire
        </a>
        <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}"
            class="px-4 py-2 rounded {{ $statusFilter === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
            En cours
        </a>
        <a href="{{ route('tasks.index', ['status' => 'done']) }}"
            class="px-4 py-2 rounded {{ $statusFilter === 'done' ? 'bg-green-500 text-white' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
            Terminées
        </a>
    </div>

    @if($tasks->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
            Aucune tâche trouvée.
            <a href="{{ route('tasks.create') }}" class="text-blue-500 hover:underline ml-1">Créer une tâche</a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Titre</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Statut</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Priorité</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Date limite</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($tasks as $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            <a href="{{ route('tasks.show', $task->id) }}" class="hover:text-blue-600">
                                {{ $task->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            @if($task->status == 'todo')
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">À faire</span>
                            @elseif($task->status == 'in_progress')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">En cours</span>
                            @else
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Terminé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($task->priority == 'low')
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs">Basse</span>
                            @elseif($task->priority == 'medium')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Moyenne</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Haute</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ $task->due_date ? $task->due_date->format('d/m/Y') : '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('tasks.show', $task->id) }}"
                                    class="text-blue-500 hover:text-blue-700 text-sm">Voir</a>
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="text-yellow-500 hover:text-yellow-700 text-sm">Modifier</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer cette tâche ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
