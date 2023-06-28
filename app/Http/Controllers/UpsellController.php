<?php

namespace App\Http\Controllers;

use App\Models\SaleFunnel;
use App\Models\User;

use Illuminate\Database\Eloquent\Collection;
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
        // Prepare data for frontend.
        $upsellStats = null;
        $customersByPlans = null;

        // Get user's latest state.
        $customersState = $this->getLatestState();
        if ($customersState) {
            // Group customers by plan.
            list($customersByPlans, $upsellStats) = $this->getGroupedPlansData($customersState);
        }

        $customersByPlans = $customersByPlans->map(function ($customersByPlan) {
            $customersByPlan['sale_funnel'] = SaleFunnel::find($customersByPlan['customers']?->first()?->latestState?->funnel_id)?->data;
            return $customersByPlan;
        });

        return view('upsell-dashboard')->with([
            'customersByPlans' => $customersByPlans,
            'upsellStats' => $upsellStats
        ]);
    }

    /**
     * Compute MRR and ARR values for a given plan with data in stored json file.
     *
     * @param int $customersCount
     * @param string $planName
     * @return array ['predicted_MRR', 'predicted_ARR', 'plan_price' ]
     */
    public function computeUpsellStats(int $customersCount, string $planName)
    {
        // Get prices from json file.
        $pricing_data_file_path = stripslashes("/users-pricing/pricing.json");
        if (Storage::exists($pricing_data_file_path)) {
            $prices = json_decode(Storage::get($pricing_data_file_path), true);
            // Get plans in pricing.json and determine stats based on plans availability.
            $plans = @$prices[Auth::user()->company_name]['plans'] ?? [];
            if (in_array(strtolower($planName), array_keys($plans))) {
                // Get planPrice and calculate MRR/ARR.
                $planPrice = $prices[Auth::user()->company_name]['plans'][strtolower($planName)]['prices'][0]['amount'];
                return [
                    'predicted_MRR' => $customersCount * $planPrice,
                    'predicted_ARR' => $customersCount * $planPrice * 12,
                    "plan_price" => $planPrice,
                    'plan_exists' => true
                ];
            }
        }
        return [
            'predicted_MRR' => 0,
            'predicted_ARR' => 0,
            'plan_price' => 0,
            'plan_exists' => false
        ];
    }

    /**
     * Groups customers into plans, calculates the MRR/ARR and sorts plans by plan_price.
     *
     * @param Collection $customers
     * @return array [$plans, $stats]
     */
    public function getGroupedPlansData(Collection $customers)
    {
        // Prepare stats data.
        $total_predicted_mrr = 0;
        $total_predicted_arr = 0;
        $number_of_users_to_upsell = 0;

        // Group and sort customers by plan.
        $plans = $customers->groupBy('latestState.predicted_plan');

        // Compute the stats for each plan, and update the stats data.
        $plans = $plans->map(function ($planCustomers, $planName) use (&$total_predicted_mrr, &$total_predicted_arr, &$number_of_users_to_upsell) {

            $upsellStats = $this->computeUpsellStats($planCustomers->whereNull('hidden_at')->count(), $planName);

            // Update stats data.
            $total_predicted_mrr += $upsellStats["predicted_MRR"];
            $total_predicted_arr += $upsellStats["predicted_ARR"];
            $number_of_users_to_upsell += $planCustomers->count();

            return ["name" => $planName, "customers" => $planCustomers, "stats" => $upsellStats];

        })->sortBy(function ($plan) {
            return $plan['stats']['plan_price'];
        });

        $stats = compact('total_predicted_mrr', 'total_predicted_arr', 'number_of_users_to_upsell');

        return [$plans, $stats];
    }

    public function show()
    {
        $customers = Auth::user()->configuration()
            ->first()
            ->customers()
            ->with('latestState')
            ->get();

        return view('upsell-historic-dashboard')->with([
            'customers' => $customers,
        ]);
    }

    /**
     * Download list of customers to upsell from the latest analysis.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Request $request)
    {
        // Prepare filename.
        $currentDate = now()->format('d-m-Y');
        $filename = "Koaila-upsell-list-{$currentDate}.csv";

        // Get the latest state of user's customers.
        $customers = $this->getLatestState();

        // Ensure hidden customers are only exported when specified.
        if ($request->type == "hidden") {
            $customers = $customers->whereNotNull('hidden_at');
        } else {
            $customers = $customers->whereNull('hidden_at');
        }

        // Prepare file headers.
        $columns = ['Email', 'Likelihood', 'User Creation Time', 'Time to Value'];
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        // Save data into csv file.
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
        // Read CSV file and get the necessary information.
        $csvFileData = Auth::user()->results()->whereIn('type', ['upsell'])->first();
        $csvFileData->data = $csvFileData->loadData();

        $prompts = json_decode(stripslashes(Storage::get("/gpt3-prompts/prompts.json")), true);
        $upsell_prompt = str_replace("[company_name]", Auth::user()->company_name, $prompts['upsell_email_prompt']);
        $upsell_prompt = str_replace("[pricing_page_url]", Auth::user()->configuration->pricing_page_url, $upsell_prompt);

        foreach ($csvFileData->data['rows'] as $row) {
            //            Convert array containing user behaviour from csv file to string with key:value.
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

    /**
     * Fetch the latest state of a user's customers.
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection $customers
     */
    public function getLatestState()
    {
        $customers = null;
        $latestDate = Auth::user()->configuration()->first()?->customerStates()?->orderByDesc('date')->first()?->date;

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

        return $customers;
    }
}