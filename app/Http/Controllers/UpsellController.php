<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class UpsellController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $results = Auth::user()->results()->whereIn('type', ['upsell'])->get()->map(function($result) {
            $result->data = $result->loadData();
            return $result;
        });

        return view('upsell-dashboard')->with([
            'results' => $results,
        ]);
    }
}
