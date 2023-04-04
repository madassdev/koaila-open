<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ConfigurationRequest;


class ConfigurationController extends Controller
{
    public function index()
    {
        return view('configuration')
            ->with(['existingConfigs'=> Auth::user()->configuration, 'tokens' => Auth::user()->tokens]);
    }

    public function store(ConfigurationRequest $request)
    {
        if(Auth::user()->configuration()->exists()){
            Auth::user()->configuration()->update($request->validated());
        }
        else{
            Auth::user()->configuration()->create($request->validated());
        }
        return redirect()->back()->with('message', 'Configuration saved!');
    }

    public function createAPIToken()
    {
        Auth::user()->createToken('MyAppToken')->accessToken;
        return redirect()->back()->with('message', 'API Key generated!');
    }
}
