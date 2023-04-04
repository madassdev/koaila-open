<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aha_moment',
        'features',
        'conversion_channel',
        'pricing_page',
        'api_token'
    ];

    protected $casts = [
        'aha_moment'=> 'array',
        'features'=> 'array',
        'conversion_channel'=> 'array',
    ];

    protected $attributes = [
        'aha_moment' => '[]',
        'features' => '[]',
        'conversion_channel' => '[]',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
