<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerState extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'email',
        'date',
        'plans',
        'predicted_plan',
        'funnel_id',
        'state',
        'linked_IDs'
    ];

    protected $casts = [
        'state' => 'array',
        'plans' => 'array',
        'linked_IDs'=>'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleFunnel()
    {
        return $this->belongsTo(SaleFunnel::class, 'funnel_id');
    }
}
