<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMetaData extends Model
{
    use HasFactory, SoftDeletes, CreateUuid;

    protected $guarded = [];

    protected $casts = [
        'metadata' => 'object'
    ];
}
