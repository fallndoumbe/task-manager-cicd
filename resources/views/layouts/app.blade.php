<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-blue-600 text-white px-6 py-4 mb-6">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="{{ route('tasks.index') }}" class="text-xl font-semibold">
                Task Manager
            </a>
            <a href="{{ route('tasks.create') }}"
                class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-gray-100">
                + Nouvelle tâche
            </a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
