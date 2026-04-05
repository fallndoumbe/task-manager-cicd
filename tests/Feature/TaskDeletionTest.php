<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_tasks_removes_task_and_redirects(): void
    {
        $task = Task::factory()->create(['title' => 'À supprimer']);

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
