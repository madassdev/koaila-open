<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user is an admin of the organization.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return bool
     */
    public function isOrganizationAdmin(User $user, Organization $organization)
    {
        // User must be admin of their organization.
        return $user->role == $organization::$adminRole;
    }

    public function isAdminOfCustomer(User $user, Organization $organization, Customer $customer)
    {
        // Customer must belong to user's organization, and user must be an admin of their organization.
        $account = $user->organization->owner ?? $user;
        return $account->ownsCustomer($customer) && $user->role == Organization::$adminRole;
    }
}