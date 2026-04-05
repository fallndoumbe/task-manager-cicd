<?php

namespace App\Http\Requests;

use App\Support\TaskValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return TaskValidationRules::rules();
    }
}
