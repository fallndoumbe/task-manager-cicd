<?php

namespace Tests\Concerns;

trait BuildsValidTaskPayload
{
    /**
     * @return array<string, mixed>
     */
    protected function validTaskPayload(): array
    {
        return [
            'title' => 'Tâche de test',
            'description' => 'Description de la tâche',
            'status' => 'todo',
            'priority' => 'medium',
            'due_date' => '2026-06-15',
        ];
    }
}
