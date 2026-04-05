<?php

namespace Tests\Unit;

use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskModelTest extends TestCase
{
    public function test_is_completed_returns_true_when_status_is_done(): void
    {
        $task = new Task(['status' => 'done']);

        $this->assertTrue($task->isCompleted());
    }

    public function test_is_completed_returns_false_when_status_is_todo(): void
    {
        $task = new Task(['status' => 'todo']);

        $this->assertFalse($task->isCompleted());
    }

    public function test_is_completed_returns_false_when_status_is_in_progress(): void
    {
        $task = new Task(['status' => 'in_progress']);

        $this->assertFalse($task->isCompleted());
    }
}
