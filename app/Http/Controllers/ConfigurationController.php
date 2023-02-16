<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ConfigurationRequest;


class ConfigurationController extends Controller
{
    public function index()
    {    
        return view('configuration')
            ->with('existingConfigs', Auth::user()->configurations()->get());
    }

    public function store(ConfigurationRequest $request, $type)
    {
        Auth::user()->configurations()->firstOrNew([
            'type' => $type
        ])->fill([
            'configuration' => $request->fields
        ])->save();

        return redirect()->back()->with('message', 'Configuration saved!');
    }
}
