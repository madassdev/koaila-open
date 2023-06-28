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
        return $user->ownsCustomer($customer);
    }

    public function toggleContactedState(User $user, Customer $customer): bool
    {
        return $user->ownsCustomer($customer);
    }
}