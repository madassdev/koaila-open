<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataMappingRequest;

class DataMappingController extends Controller
{
    public function store(DataMappingRequest $request)
    {
        $input = $request->all();

        $product = DataMapping::create($input);

        return $this->sendResponse(new ProductResource($product), 'Mapping created successfully.');
    }
}
