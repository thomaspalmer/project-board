<?php

namespace App\Models;

use App\Enums\{Priorities, DescriptionTypes};
use Illuminate\Database\Eloquent\{Builder, Factories\HasFactory, Model, Relations\BelongsTo};

class Task extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'source_id', 'title', 'description', 'description_type', 'priority', 'due_at', 'completed_at',
        'link', 'external_id',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'due_at',
        'completed_at',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'high_priority',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'priority' => Priorities::class,
        'description_type' => DescriptionTypes::class,
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * @return bool
     */
    public function getHighPriorityAttribute(): bool
    {
        return $this->priority === Priorities::High;
    }

    /**
     * @return Builder
     */
    public function scopePriorityOrder(): Builder
    {
        $priorityOrder = '\'' . collect(Priorities::cases())
                ->map(fn ($priority) => $priority->value)
                ->join('\', \'') . '\'';

        return $this
            ->whereNull('completed_at')
            ->orderByRaw('FIELD(priority, ' . $priorityOrder . ')')
            ->orderBy('due_at', 'asc')
            ->orderBy('created_at', 'asc');
    }
}
