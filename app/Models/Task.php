<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Illuminate\Support\Carbon|null $due_date
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'priority', 'due_date'];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    public function isCompleted(): bool
    {
        return $this->status === 'done';
    }
}
