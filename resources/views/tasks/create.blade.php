@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow">
    <h1 class="text-2xl font-semibold mb-6">Créer une nouvelle tâche</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Titre *</label>
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Ex: Mettre en place le pipeline CI/CD">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Description</label>
            <textarea name="description" rows="4"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Décrivez la tâche...">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Statut *</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="todo"        {{ old('status', 'todo') === 'todo'        ? 'selected' : '' }}>À faire</option>
                <option value="in_progress" {{ old('status') === 'in_progress'         ? 'selected' : '' }}>En cours</option>
                <option value="done"        {{ old('status') === 'done'                ? 'selected' : '' }}>Terminé</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Priorité *</label>
            <select name="priority" class="w-full border rounded px-3 py-2">
                <option value="low"    {{ old('priority') === 'low'               ? 'selected' : '' }}>Basse</option>
                <option value="medium" {{ old('priority', 'medium') === 'medium'  ? 'selected' : '' }}>Moyenne</option>
                <option value="high"   {{ old('priority') === 'high'              ? 'selected' : '' }}>Haute</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Date limite</label>
            <input type="date" name="due_date" value="{{ old('due_date') }}"
                min="{{ date('Y-m-d') }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex gap-4">
            <button type="submit"
                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Créer la tâche
            </button>
            <a href="{{ route('tasks.index') }}"
                class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection