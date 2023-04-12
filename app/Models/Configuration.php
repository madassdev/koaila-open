<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'aha_moment',
        'features',
        'conversion_channel',
        'pricing_page',
        'uuid'
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

    protected static function booted(): void
    {
        static::creating(function (Configuration $config) {
            $config->uuid = Str::uuid();
        });
    }
}
