<?php

namespace App\Http\Controllers;

class DataMappingController extends Controller
{
    public function store(DataMappingRequest $request)
    {
//        $user = User::find($user_id);
//
//        if (!$user) {
//            return response()->json(['error' => 'User not found'], 404);
//        }
//
//        $dataMapping = new DataMapping;
//
//        $user->dataMapping()->save($dataMapping);

        return response()->json(['success' => true]);
    }
}
