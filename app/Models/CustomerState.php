<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerState extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
