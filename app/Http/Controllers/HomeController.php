<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use App\Models\Result;

use function PHPUnit\Framework\fileExists;

class HomeController extends Controller
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
        $results = Auth::user()->results->map(function($result) {
            $result->data = $result->loadData();
            return $result;
        });

        return view('home')->with([
            'results' => $results,
        ]);
    }
}
