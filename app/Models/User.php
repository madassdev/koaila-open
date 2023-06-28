<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name',
        'role',
        'organization_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function integrations()
    {
        return $this->hasMany(Integration::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }
    
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Determine if the authenticated user owns the given customer.
     *
     * @param  \App\Models\Customer  $customer
     * @return bool
     */
    public function ownsCustomer(Customer $customer): bool
    {
        return $this->configuration()->where('id', $customer->config_id)->exists();
    }

    /**
     * Getter for the "is_admin" attribute of the user. This is determined from the value in "role" column.
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return $this->role == $this->organization::$adminRole;
    }
}