<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DataMappingRequest;
use App\Models\Configuration;
use App\Models\DataMapping;
class DataMappingController extends Controller
{
    public function store(DataMappingRequest $request)
    {
        $input = $request->all();

        $input['config_id'] = Configuration::where('uuid',$request->config_uuid)->firstOrFail()->id;

        DataMapping::create($input);

        return response(['message' => 'Mapping created successfully.']);
    }
}
