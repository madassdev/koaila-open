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
        'pricing_page_url',
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

    public function customers()
    {
        return $this->hasMany(Customer::class,'config_id');
    }

    public function customerStates()
    {
        return $this->hasManyThrough(CustomerState::class,Customer::class,'config_id','customer_id');
    }

    public function saleFunnels()
    {
        return $this->hasMany(SaleFunnel::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Configuration $config) {
            $config->uuid = Str::uuid();
        });
    }
}
