<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Tâches</title>
</head>
<body>
<h1>Tâches</h1>
@if(isset($statusFilter) && $statusFilter)
    <p>Filtre : {{ $statusFilter }}</p>
@endif
<ul>
    @foreach($tasks as $task)
        <li>{{ $task->title }} ({{ $task->status }})</li>
    @endforeach
</ul>
</body>
</html>
