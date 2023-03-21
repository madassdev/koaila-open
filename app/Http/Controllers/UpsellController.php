<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function download(){
        $path = 'results/'.Auth::user()->results->firstWhere('type','upsell')->filename;
        return Storage::download($path);
    }

    public function sendUpsellEmails(){
        // Read CSV file and get the necessary information
        $csvFileData = Auth::user()->results()->whereIn('type', ['upsell'])->get()->map(function($result) {
            $result->data = $result->loadData();
            return $result;
        });

        $gpt3GeneratedEmail = sendGPT3Request('write a love message to Julien', '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', 'davinci');
        if($gpt3GeneratedEmail['body']['error'] != null){
            dd($gpt3GeneratedEmail['body']['error']['message']);
        }


    }
}
