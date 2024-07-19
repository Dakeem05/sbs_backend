<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory, CreateUuid;

    protected $guarded = [];
    
    protected $casts = [
        'metadata' => 'object',
        'is_active' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function menus (): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
