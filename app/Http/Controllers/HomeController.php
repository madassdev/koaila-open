<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;

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
        $filePath = public_path("/csv/".Auth::user()->result_file_name);
        if (fileExists($filePath)){
            $rows = array_map('str_getcsv', file($filePath));
            $headers = array_shift($rows);
            $csv = array();
            foreach ($rows as $row) {
                $csv[] = array_combine($headers, $row);
            }
            return view('home')->with([
                'headers'=>$headers,
                'rows'=>$csv,
            ]);
        }
        return view('home');
    }
}
