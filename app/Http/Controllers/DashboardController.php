<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use App\Models\Result;

use function PHPUnit\Framework\fileExists;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $results = Auth::user()->results()->whereIn('type', ['feature_adoption','time_to_value','daumau', 'waumau'])->get()->map(function($result) {
            $result->data = $result->loadData();
            return $result;
        });

        return view('dashboard')->with([
            'results' => $results,
        ]);
    }
}
