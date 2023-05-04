<?php

namespace App\Http\Controllers;
use App\Models\CustomerState;
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
        $results = Auth::user()->results()->whereIn('type', ['sale_funnel','upsell_stats'])->get()->map(function($result) {
            $result->data = $result->loadData();
            return $result;
        });

        $latestDate = Auth::user()->configuration()->first()->customerStates()->orderByDesc('date')->first()?->date;

        $customers = Auth::user()->configuration()
            ->first()
            ->customers()
            ->whereHas('latestState', function ($q) use ($latestDate) {
                $latestDateWithoutSeconds = date('Y-m-d H:i:00', strtotime($latestDate));
                return $q->whereRaw("to_char(date, 'YYYY-MM-DD HH24:MI:00') = ?", [$latestDateWithoutSeconds]);
            })
            ->with('latestState')
            ->get();

        return view('upsell-dashboard')->with([
            'results' => $results,
            'customers' => $customers,
        ]);
    }

    public function show(){
        $latestDate = Auth::user()->configuration()->first()->customerStates()->orderByDesc('date')->first()?->date;

        $customers = Auth::user()->configuration()
            ->first()
            ->customers()
            ->whereHas('latestState', function ($q) use ($latestDate) {
                $latestDateWithoutSeconds = date('Y-m-d H:i:00', strtotime($latestDate));
                return $q->whereRaw("to_char(date, 'YYYY-MM-DD HH24:MI:00') < ?", [$latestDateWithoutSeconds]);
            })
            ->with('latestState')
            ->get();

        return view('upsell-historic-dashboard')->with([
            'customers' => $customers,
        ]);
    }

    public function download(){
        $path = 'results/'.Auth::user()->results->firstWhere('type','upsell')->filename;
        return Storage::download($path);
    }

    public function destroy($customerStateId){
        CustomerState::find($customerStateId)->delete();
        return redirect()->route('upsell-dashboard');
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
