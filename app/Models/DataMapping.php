<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_id',
        'usage_tracking_id',
        'email',
    ];

    protected $hidden = [
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
