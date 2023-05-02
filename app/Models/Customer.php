<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'config_id',
        'stripe_id',
        'usage_tracking_id',
        'email',
    ];

    public function states()
    {
        return $this->hasMany(CustomerState::class,'customer_id');
    }

    public function latestState()
    {
        return $this->hasOne(CustomerState::class)->latestOfMany();
    }

    public function configuration()
    {
        return $this->belongsTo(Configuration::class);
    }
}
