<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_tasks_show_displays_task_details(): void
    {
        $task = Task::factory()->create([
            'title' => 'Détail de la tâche',
            'description' => 'Texte descriptif',
        ]);

        $response = $this->get(route('tasks.show', $task));

        $response->assertOk();
        $response->assertSee('Détail de la tâche', false);
        $response->assertSee('Texte descriptif', false);
    }
}
