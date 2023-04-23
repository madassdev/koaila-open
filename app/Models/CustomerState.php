<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerState extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_email',
        'date',
        'state',
    ];

    protected $hidden = [
        'state',
    ];

    protected $casts = [
        'state' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
