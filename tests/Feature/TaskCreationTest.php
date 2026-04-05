<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\BuildsValidTaskPayload;
use Tests\TestCase;

class TaskCreationTest extends TestCase
{
    use BuildsValidTaskPayload;
    use RefreshDatabase;

    public function test_get_tasks_create_displays_form(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertOk();
        $response->assertSee('Créer une tâche', false);
    }

    public function test_post_tasks_creates_task_and_redirects(): void
    {
        $payload = $this->validTaskPayload();

        $response = $this->post(route('tasks.store'), $payload);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tasks', [
            'title' => $payload['title'],
            'description' => $payload['description'],
            'status' => $payload['status'],
            'priority' => $payload['priority'],
        ]);

        $task = Task::query()->first();
        $this->assertNotNull($task);
        $this->assertSame('2026-06-15', $task->due_date->format('Y-m-d'));
    }

    public function test_post_tasks_rejects_missing_title(): void
    {
        $payload = $this->validTaskPayload();
        unset($payload['title']);

        $response = $this->from(route('tasks.create'))->post(route('tasks.store'), $payload);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_post_tasks_rejects_invalid_status(): void
    {
        $payload = $this->validTaskPayload();
        $payload['status'] = 'invalid_status';

        $response = $this->from(route('tasks.create'))->post(route('tasks.store'), $payload);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors('status');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_post_tasks_rejects_invalid_priority(): void
    {
        $payload = $this->validTaskPayload();
        $payload['priority'] = 'urgent';

        $response = $this->from(route('tasks.create'))->post(route('tasks.store'), $payload);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors('priority');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_post_tasks_accepts_null_description_and_due_date(): void
    {
        $payload = [
            'title' => 'Sans optionnels',
            'description' => null,
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => null,
        ];

        $response = $this->post(route('tasks.store'), $payload);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'title' => 'Sans optionnels',
            'description' => null,
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => null,
        ]);
    }
}
