<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function show($email)
    {
        $customer = Auth::user()->configuration()->first()->customers()->where('email', $email)->with('states')->get();

        return view('customer-dashboard')->with([
            'customer' => $customer,
        ]);
    }
}
