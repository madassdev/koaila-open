<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function toggleVisibility(User $user, Customer $customer): bool
    {
        return $user->configuration()->where('id', $customer->config_id)->exists();
    }

    public function assignToMember(User $user, Customer $customer)
    {
        // Customer must belong to user, and user must be admin of their organization.
        return $user->configuration()->where('id', $customer->config_id)->exists() && $user->role == 'admin';
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @param Customer $customer
     * @return boolean
     */
    public function showCustomerInfo(User $user, Customer $customer)
    {
        // Customer can only be viewed by an assigned user, or an admin of the organization they belong to.
        if ($customer->user_id == $user->id) {
            return true;
        } else {
            // Customer can be viewed by their admin, or an organization user whose role is admin.
            $organizationAccount = $user->organization->owner ?? $user;
            return $organizationAccount->configuration()->where('id', $customer->config_id)->exists() && $user->role == 'admin';
        }
    }
}