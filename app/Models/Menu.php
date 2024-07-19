<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory, CreateUuid;

    protected $guarded = [];
    
    protected $casts = [
        'metadata' => 'object',
        'is_available' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function business (): BelongsTo
    {
        return $this->BelongsTo(Business::class);
    }
}
