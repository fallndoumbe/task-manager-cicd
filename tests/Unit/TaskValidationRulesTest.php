<?php

namespace Tests\Unit;

use App\Support\TaskValidationRules;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TaskValidationRulesTest extends TestCase
{
    public static function validStatusesProvider(): array
    {
        return [
            'todo' => ['todo'],
            'in_progress' => ['in_progress'],
            'done' => ['done'],
        ];
    }

    #[DataProvider('validStatusesProvider')]
    public function test_status_accepts_allowed_values(string $status): void
    {
        $data = [
            'title' => 'X',
            'description' => null,
            'status' => $status,
            'priority' => 'medium',
            'due_date' => null,
        ];

        $validator = Validator::make($data, TaskValidationRules::rules());

        $this->assertFalse($validator->fails(), "Status « {$status} » devrait être valide.");
    }

    public function test_status_rejects_invalid_value(): void
    {
        $data = [
            'title' => 'X',
            'status' => 'archived',
            'priority' => 'medium',
        ];

        $validator = Validator::make($data, TaskValidationRules::rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('status', $validator->errors()->messages());
    }

    public static function validPrioritiesProvider(): array
    {
        return [
            'low' => ['low'],
            'medium' => ['medium'],
            'high' => ['high'],
        ];
    }

    #[DataProvider('validPrioritiesProvider')]
    public function test_priority_accepts_allowed_values(string $priority): void
    {
        $data = [
            'title' => 'X',
            'status' => 'todo',
            'priority' => $priority,
        ];

        $validator = Validator::make($data, TaskValidationRules::rules());

        $this->assertFalse($validator->fails(), "Priorité « {$priority} » devrait être valide.");
    }

    public function test_priority_rejects_invalid_value(): void
    {
        $data = [
            'title' => 'X',
            'status' => 'todo',
            'priority' => 'critical',
        ];

        $validator = Validator::make($data, TaskValidationRules::rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('priority', $validator->errors()->messages());
    }
}
