<?php

namespace App\Http\Controllers;

use App\Http\Requests\IntegrationRequest;
use App\Models\Integration;
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
        return view('integrations-forms', ['type' => $type]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(IntegrationRequest $request, $type)
    {
        Auth::user()->integrations()->firstOrNew([
            'type' => $type
        ])->fill([
            'data' => $request->except('_token')
        ])->save();

        return redirect()->back()->with('message', 'Integration successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Integration $integrations
     * @return \Illuminate\Http\Response
     */
    public function show(Integration $integration)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Integrations $integrations
     * @return \Illuminate\Http\Response
     */
    public function edit(Integration $integration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Integrations $integrations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Integration $integration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Integrations $integrations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Integration $integration)
    {
        //
    }
}
