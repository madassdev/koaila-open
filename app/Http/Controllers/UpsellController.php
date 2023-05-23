<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Response;

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
        $results = Auth::user()->results()->whereIn('type', ['sale_funnel', 'upsell_stats'])->get()->map(function ($result) {
            $result->data = $result->loadData();
            return $result;
        });

        $latestDate = Auth::user()->configuration()->first()?->customerStates()?->orderByDesc('date')->first()?->date;

        $customers = null;

        if ($latestDate) {
            $customers = Auth::user()->configuration()
                ->first()
                ->customers()
                ->whereHas('latestState', function ($q) use ($latestDate) {
                    $latestDateWithoutSeconds = date('Y-m-d H:i:00', strtotime($latestDate));
                    return $q->whereRaw("to_char(date, 'YYYY-MM-DD HH24:MI:00') = ?", [$latestDateWithoutSeconds]);
                })
                ->with('latestState')
                ->get();
        }

        return view('upsell-dashboard')->with([
            'results' => $results,
            'customers' => $customers,
        ]);
    }

    public function show()
    {
        $latestDate = Auth::user()->configuration()->first()?->customerStates()?->orderByDesc('date')->first()?->date;
        $customers = null;
        if ($latestDate) {
            $customers = Auth::user()->configuration()
                ->first()
                ->customers()
                ->whereHas('latestState', function ($q) use ($latestDate) {
                    $latestDateWithoutSeconds = date('Y-m-d H:i:00', strtotime($latestDate));
                    return $q->whereRaw("to_char(date, 'YYYY-MM-DD HH24:MI:00') < ?", [$latestDateWithoutSeconds]);
                })
                ->with('latestState')
                ->get();
        }
        return view('upsell-historic-dashboard')->with([
            'customers' => $customers,
        ]);
    }

    public function download(Request $request)
    {
        // Prepare filename
        $currentDate = now()->format('d-m-Y');
        $filename = "Koaila-upsell-list-{$currentDate}.csv";

        // Fetch data as it is on the index page
        $latestDate = Auth::user()->configuration()->first()?->customerStates()?->orderByDesc('date')->first()?->date;
        $customers = Auth::user()->configuration()
            ->first()
            ->customers()
            ->whereHas('latestState', function ($q) use ($latestDate) {
                $latestDateWithoutSeconds = date('Y-m-d H:i:00', strtotime($latestDate));
                return $q->whereRaw("to_char(date, 'YYYY-MM-DD HH24:MI:00') = ?", [$latestDateWithoutSeconds]);
            })
            ->with('latestState')
            ->get();

        // Ensure hidden customers are only exported when specified
        if ($request->type == "hidden") {
            $customers = $customers->whereNotNull('hidden_at');
        } else {
            $customers = $customers->whereNull('hidden_at');
        }

        // Prepare file headers
        $columns = ['Email', 'Likelihood', 'User Creation Time', 'Time to Value'];
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        // Save data into csv file
        $callback = function () use ($columns, $customers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);
            foreach ($customers as $customer) {
                fputcsv($handle, [
                    $customer->email,
                    $customer->latestState->state['likelihood'],
                    $customer->latestState->state['user_creation_time'],
                    $customer->latestState->state['time_to_value'],
                ]);
            }
            fclose($handle);
        };

        return Response::streamDownload($callback, $filename, $headers);
    }

    public function sendUpsellEmails()
    {
        // Read CSV file and get the necessary information
        $csvFileData = Auth::user()->results()->whereIn('type', ['upsell'])->first();
        $csvFileData->data = $csvFileData->loadData();

        $prompts = json_decode(stripslashes(Storage::get("/gpt3-prompts/prompts.json")), true);
        $upsell_prompt = str_replace("[company_name]", Auth::user()->company_name, $prompts['upsell_email_prompt']);
        $upsell_prompt = str_replace("[pricing_page_url]", Auth::user()->configuration->pricing_page_url, $upsell_prompt);

        foreach ($csvFileData->data['rows'] as $row) {
            //            Convert array containing user behaviour from csv file to string with key:value
            $userAttributes = array_map(function ($value, $key) {
                return $key . '="' . $value . '"';
            }, array_values($row), array_keys($row));
            $userAttributes = implode(' ', $userAttributes);

            $upsell_prompt = $upsell_prompt . ' ' . $userAttributes;
            dd($upsell_prompt);

            $gpt3GeneratedEmail = sendGPT3Request(
                $upsell_prompt,
                config('services.open_ai.api_key'),
                'davinci'
            );
            if ($gpt3GeneratedEmail['body']['error'] != null) {
                dd($gpt3GeneratedEmail['body']['error']['message']);
            }
        }
        return null;
    }

    public function test()
    {
        return $this->computeUpsellStats(3, 'starter');
    }
    public function computeUpsellStats($customersCount, $plan)
    {
        // return 123;
        $path = Storage::disk('public')->path('upsell-anonymised.csv');
        return $path;
        $prices = json_decodes(stripslashes(Storage::get("/users-pricing/pricing.json")), true);
        $planPrice = $prices[Auth::user()->company_name]['plans'][$plan]['prices'][0]['amount'];
        $upsellStats = ['predicted_MRR' => $customersCount * $planPrice, 'predicted_ARR' => $customersCount * $planPrice * 12,];
        return $upsellStats;
    }
}