<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignCustomerToMemberRequest;
use App\Models\Customer;
use App\Models\SaleFunnel;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Shows details of a customer.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException

    */
    public function show($id)
    {
        // Use the organization owner's user account, or use authenticated user when organization is not yet setup. 
        $account = Auth::user()->organization?->owner ?? Auth::user();
        $customer = $account->configuration()->first()->customers()->where('id', $id)->with('states')->firstOrFail();

        $this->authorize('showCustomerInfo', $customer);

        // Fetch  customer's sale funnel data.
        $saleFunnel = SaleFunnel::find($customer->latestState->funnel_id);

        return view('customer-dashboard')->with([
            'customer' => $customer,
            'saleFunnel' => $saleFunnel,
        ]);
    }

    /**
    * Toggles a customer's visibility on the dashboard.
    *
    * @param int $customerId
    * @return \Illuminate\Http\RedirectResponse 
    * 
    * @throws \Illuminate\Auth\Access\AuthorizationException

   */
    public function toggleVisibility($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->authorize('toggleVisibility', $customer);

        $hiddenAt = $customer->hidden_at == null ? now() : null;
        $customer->update(['hidden_at' => $hiddenAt]);

        return redirect()->route('upsell-dashboard');
    }

    /**
     * Updates customer contacted status.
     *
     * @param int $customerId
     * @return \Illuminate\Routing\Redirector
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException

     */
    public function toggleContactedState($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $this->authorize('toggleContactedState', $customer);

        $customer->update(['contacted' => !$customer->contacted]);

        return redirect()->route('upsell-dashboard');
    }

    /**
     * Assign customer to a member in same organization as authenticated user.
     *
     * @param \App\Http\Requests\AssignCustomerToMemberRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException

    */
    public function assignToMember(AssignCustomerToMemberRequest $request, Authenticatable $user)
    {
        $customer = Customer::findOrFail($request->customer_id);

        // Ensure user can assign the customer to a member in their organization.
        $this->authorize('isAdminOfCustomer', [$user->organization, $customer]);

        if ($request->member_id) {
            // Member must belong to authenticated user's organization.
            $member = User::whereId($request->member_id)->whereOrganizationId($user->organization_id)->firstOrFail();
            $customer->user_id = $member->id;
        } else {
            // Make customer unassigned to any user.
            $customer->user_id = null;
        }

        $customer->save();

        return back()->with('message', 'Customer updated successfully.');
    }
}