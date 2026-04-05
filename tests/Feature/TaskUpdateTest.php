<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\BuildsValidTaskPayload;
use Tests\TestCase;

class TaskUpdateTest extends TestCase
{
    use BuildsValidTaskPayload;
    use RefreshDatabase;

    public function test_get_tasks_edit_displays_task(): void
    {
        $task = Task::factory()->create(['title' => 'Tâche à modifier']);

        $response = $this->get(route('tasks.edit', $task));

        $response->assertOk();
        $response->assertSee('Tâche à modifier', false);
    }

    public function test_put_tasks_updates_task_and_redirects(): void
    {
        $task = Task::factory()->create([
            'title' => 'Ancien titre',
            'status' => 'todo',
            'priority' => 'low',
        ]);

        $payload = $this->validTaskPayload();
        $payload['title'] = 'Nouveau titre';
        $payload['status'] = 'done';

        $response = $this->put(route('tasks.update', $task), $payload);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Nouveau titre',
            'status' => 'done',
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'title' => 'Ancien titre',
        ]);
    }

    public function test_put_tasks_rejects_invalid_data(): void
    {
        $task = Task::factory()->create();

        $payload = $this->validTaskPayload();
        $payload['title'] = '';

        $response = $this->from(route('tasks.edit', $task))->put(route('tasks.update', $task), $payload);

        $response->assertRedirect(route('tasks.edit', $task));
        $response->assertSessionHasErrors('title');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $task->title,
        ]);
    }
}
