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
}
