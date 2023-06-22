<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleFunnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'config_id',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }

    public function states()
    {
        return $this->hasMany(CustomerState::class,'funnel_id');
    }
}
