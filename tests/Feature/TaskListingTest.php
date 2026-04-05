<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_tasks_lists_all_tasks_ordered_by_newest(): void
    {
        $older = Task::factory()->create(['title' => 'Plus ancienne', 'created_at' => now()->subDay()]);
        $newer = Task::factory()->create(['title' => 'Plus récente', 'created_at' => now()]);

        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertSeeInOrder(['Plus récente', 'Plus ancienne']);
    }

    public function test_get_tasks_filters_by_status_query_parameter(): void
    {
        Task::factory()->create(['title' => 'À faire A', 'status' => 'todo']);
        Task::factory()->create(['title' => 'En cours B', 'status' => 'in_progress']);
        Task::factory()->create(['title' => 'Terminée C', 'status' => 'done']);

        $response = $this->get(route('tasks.index', ['status' => 'todo']));

        $response->assertOk();
        $response->assertSee('À faire A');
        $response->assertDontSee('En cours B');
        $response->assertDontSee('Terminée C');
    }

    public function test_get_tasks_ignores_invalid_status_filter(): void
    {
        Task::factory()->create(['title' => 'Visible', 'status' => 'todo']);

        $response = $this->get(route('tasks.index', ['status' => 'not_a_status']));

        $response->assertOk();
        $response->assertSee('Visible');
    }
}
