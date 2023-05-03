<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function show($email)
    {
        $customer = Auth::user()->configuration()->first()->customers()->where('email', $email)->with('states')->get();

        $saleFunnel = Auth::user()->results()->whereIn('type', ['sale_funnel'])->get()->map(function($result) {
            $result->data = $result->loadData();
            return $result;
        })->firstWhere('type','sale_funnel');

        return view('customer-dashboard')->with([
            'customer' => $customer,
            'saleFunnel' => $saleFunnel,
        ]);
    }
}
