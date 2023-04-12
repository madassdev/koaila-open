<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Configuration;
use App\Models\Customer;
class CustomerController extends Controller
{
    public function store(CustomerRequest $request)
    {
        $input = $request->all();

        $input['config_id'] = Configuration::where('uuid',$request->config_uuid)->firstOrFail()->id;

        Customer::create($input);

        return response(['message' => 'Mapping created successfully.']);
    }

//    Add columns to customer table: upsell data , timestamp, step in funnel, link to amplitude/mixpanel
//    Upsell data JSON {
//        column1: value,
//        column2: value,
//      }
//    Step in funnel, list of events performed [event1, event2,...]
//    Link string
//    In post request we need the user ID and the users email
//    Should I create a separate table to store this info?
}
