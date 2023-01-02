<?php

namespace App\Models;

use App\Enums\Vendors;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Source extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'name', 'vendor', 'active', 'credentials', 'error',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'credentials',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'vendor' => Vendors::class,
        'active' => 'boolean',
        'credentials' => 'encrypted:array',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array
     */
    public function getVendorInfoAttribute(): array
    {
        return collect(config('vendors'))
            ->filter(fn ($vendor) => $vendor['value'] === $this->vendor)
            ->first();
    }
}
