@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Toutes les tâches</h1>
    <a href="{{ route('tasks.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Nouvelle tâche
    </a>
</div>

{{-- Filtres par statut --}}
<div class="flex gap-2 mb-6">
    <a href="{{ route('tasks.index') }}"
        class="px-4 py-2 rounded border text-sm
        {{ !$statusFilter ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
        Toutes
    </a>
    <a href="{{ route('tasks.index', ['status' => 'todo']) }}"
        class="px-4 py-2 rounded border text-sm
        {{ $statusFilter === 'todo' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
        À faire
    </a>
    <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}"
        class="px-4 py-2 rounded border text-sm
        {{ $statusFilter === 'in_progress' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
        En cours
    </a>
    <a href="{{ route('tasks.index', ['status' => 'done']) }}"
        class="px-4 py-2 rounded border text-sm
        {{ $statusFilter === 'done' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
        Terminées
    </a>
</div>

@if($tasks->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
        Aucune tâche trouvée.
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Titre</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Priorité</th>
                    <th class="px-4 py-3 text-left">Date limite</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($tasks as $task)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $task->title }}</td>

                    <td class="px-4 py-3">
                        @php
                            $statusClasses = [
                                'todo'        => 'bg-gray-100 text-gray-700',
                                'in_progress' => 'bg-yellow-100 text-yellow-700',
                                'done'        => 'bg-green-100 text-green-700',
                            ];
                            $statusLabels = [
                                'todo'        => 'À faire',
                                'in_progress' => 'En cours',
                                'done'        => 'Terminé',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $statusClasses[$task->status] }}">
                            {{ $statusLabels[$task->status] }}
                        </span>
                    </td>

                    <td class="px-4 py-3">
                        @php
                            $priorityClasses = [
                                'low'    => 'bg-blue-100 text-blue-700',
                                'medium' => 'bg-orange-100 text-orange-700',
                                'high'   => 'bg-red-100 text-red-700',
                            ];
                            $priorityLabels = [
                                'low'    => 'Basse',
                                'medium' => 'Moyenne',
                                'high'   => 'Haute',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $priorityClasses[$task->priority] }}">
                            {{ $priorityLabels[$task->priority] }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-gray-600">
                        {{ $task->due_date ? $task->due_date->format('d/m/Y') : '—' }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('tasks.show', $task->id) }}"
                                class="text-blue-600 hover:underline text-xs">Voir</a>
                            <a href="{{ route('tasks.edit', $task->id) }}"
                                class="text-yellow-600 hover:underline text-xs">Modifier</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                onsubmit="return confirm('Supprimer cette tâche ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:underline text-xs">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection