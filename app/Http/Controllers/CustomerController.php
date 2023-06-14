<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerState;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Shows a customer's details
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $customer = Auth::user()->configuration()->first()->customers()->where('id', $id)->with('states')->get();

        $saleFunnel = Auth::user()->results()->whereIn('type', ['sale_funnel'])->get()->map(function ($result) {
            $result->data = $result->loadData();
            return $result;
        })->firstWhere('type', 'sale_funnel');

        return view('customer-dashboard')->with([
            'customer' => $customer,
            'saleFunnel' => $saleFunnel,
        ]);
    }

    /**
     * Updates customer visibility status.
     *
     * @param int $customerId
     * @return \Illuminate\Routing\Redirector
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
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
}