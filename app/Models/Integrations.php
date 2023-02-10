<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrations extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'data',
    ];

    protected $hidden = [
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
