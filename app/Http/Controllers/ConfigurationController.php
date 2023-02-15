<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ConfigurationRequest;


class ConfigurationController extends Controller
{
    public function index()
    {
        // if(Auth::user()->configurations->where("type","aha_moment")->exists()){
        //     $existing_config = Auth::user()->configurations->where("type","aha_moment")->first()->configuration;
        // }
        // else{
        //     $existing_config=[
        //         "name"=> "",
        //         "event"=>"",
        //     ];
        // }
        $existing_config=[
            "name"=> 'Name',
            "event"=>'Event',
        ];
        return view('configuration')->with('existing_config',$existing_config);
    }

    public function store(ConfigurationRequest $request, $type)
    {
        Auth::user()->configurations()->create([
            'type' => $type,
            'configuration' => json_encode($request->fields)
        ]);
        return redirect()->back()->with('message', 'Configuration saved!');
    }
}
