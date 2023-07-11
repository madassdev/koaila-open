<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function toggleVisibility(User $user, Customer $customer): bool
    {
        return $user->ownsCustomer($customer);
    }

    public function toggleContactedState(User $user, Customer $customer): bool
    {
        return $user->ownsCustomer($customer);
    }


    public function showCustomerInfo(User $user, Customer $customer)
    {
        // Customer can only be viewed by an assigned user, or an admin of the organization they belong to.
        if ($customer->user_id == $user->id) {
            return true;
        } else {
            return  $this->isAdminOfCustomer($user, $customer);
        }
    }

    public function isAdminOfCustomer(User $user, Customer $customer)
    {
        // Customer must belong to user's organization, and user must be an admin of their organization.
        $account = $user->organization->owner ?? $user;
        return $account->ownsCustomer($customer) && $user->role == Organization::$adminRole;
    }
}