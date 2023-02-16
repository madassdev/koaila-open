<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntegrationRequest;
use App\Models\Integrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntegrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('integrations');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        return view('integrations-forms',['type' => $type]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IntegrationRequest $request, $type)
    {
        Auth::user()->integrations()->create([
            'type' => $type,
            'data' => $request->except('_token')
        ]);
        return redirect()->back()->with('message', 'Integration successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Integrations  $integrations
     * @return \Illuminate\Http\Response
     */
    public function show(Integrations $integrations)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Integrations  $integrations
     * @return \Illuminate\Http\Response
     */
    public function edit(Integrations $integrations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Integrations  $integrations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Integrations $integrations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Integrations  $integrations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Integrations $integrations)
    {
        //
    }
}
