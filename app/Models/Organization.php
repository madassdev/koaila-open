<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number_of_employees'];
    public static $roles = ['admin', 'member'];
    public static $adminRole = 'admin';
    public static $memberRole = 'member';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Gets the admin user that owns the organization.
     *
     * @return \App\Models\User|null
     */
    public function getOwnerAttribute()
    {
        // The owner  is the  first user with the role 'admin'. In the case where the organization is yet to be setup, then return the authenticated user;
        return User::whereOrganizationId($this->id)->whereRole('admin')->orderBy('created_at', 'ASC')->first() ?? auth()->user();
    }
}