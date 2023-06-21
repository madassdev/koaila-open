<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\CustomerState;
use App\Models\SaleFunnel;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function show($id)
    {
        $customer = Auth::user()->configuration()->first()->customers()->where('id', $id)->with('states')->get();

        // Fetch  customer's sale funnel data
        $saleFunnel = SaleFunnel::find($customer->first()->latestState->funnel_id);

        return view('customer-dashboard')->with([
            'customer' => $customer,
            'saleFunnel' => $saleFunnel,
        ]);
    }

    public function toggleVisibility($customerId){
        $customer = Customer::findOrFail($customerId);
        $this->authorize('toggleVisibility', $customer);

        $hiddenAt = $customer->hidden_at == null ? now() : null;
        $customer->update(['hidden_at'=> $hiddenAt]);

        return redirect()->route('upsell-dashboard');
    }
}
