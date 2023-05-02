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
        $results = Auth::user()->results()->whereIn('type', ['sale_funnel','upsell_stats','upsell'])->get()->map(function($result) {
            $result->data = $result->loadData();
            return $result;
        });

        $customers = Auth::user()->configuration()->first()->customers()->with('latestState')->get();

        return view('upsell-dashboard')->with([
            'results' => $results,
            'customers' => $customers,
        ]);
    }

    public function download(){
        $path = 'results/'.Auth::user()->results->firstWhere('type','upsell')->filename;
        return Storage::download($path);
    }

    public function sendUpsellEmails(){
        // Read CSV file and get the necessary information
        $csvFileData = Auth::user()->results()->whereIn('type', ['upsell'])->first();
        $csvFileData->data = $csvFileData->loadData();

        $prompts = json_decode(stripslashes(Storage::get("/gpt3-prompts/prompts.json")),true);
        $upsell_prompt = str_replace("[company_name]", Auth::user()->company_name, $prompts['upsell_email_prompt']);
        $upsell_prompt = str_replace("[pricing_page_url]", Auth::user()->configuration->pricing_page_url, $upsell_prompt);

        foreach($csvFileData->data['rows'] as $row){
//            Convert array containing user behaviour from csv file to string with key:value
            $userAttributes = array_map(function($value, $key) {
                return $key.'="'.$value.'"';
            }, array_values($row), array_keys($row));
            $userAttributes = implode(' ', $userAttributes);

            $upsell_prompt=$upsell_prompt.' '.$userAttributes;
            dd($upsell_prompt);

            $gpt3GeneratedEmail = sendGPT3Request(
                $upsell_prompt,
                config('services.open_ai.api_key'),
                'davinci');
            if($gpt3GeneratedEmail['body']['error'] != null){
                dd($gpt3GeneratedEmail['body']['error']['message']);
            }
        }
        return null;
    }
}
