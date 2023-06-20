<?php

namespace App\Console\Commands;

use App\Models\Configuration;
use App\Models\CustomerState;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\CSV;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportUpsellListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:upsell-list {company_name} {config_id} {file_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $configId = $this->argument('config_id');
        if (!Configuration::whereId($configId)->exists()) {
            $this->error('Configuration does not exist.');
            return Command::FAILURE;
        }
        $upsell_filePath = $this->argument('file_path');
        if (Storage::exists($upsell_filePath)) {
            $customersData = json_decode(Storage::get($upsell_filePath), true);
            foreach ($customersData as $customerData) {
                if(!str_contains(substr($customerData['email'], strpos($customerData['email'], '@') + 1), $this->argument("company_name"))){
                    $customer = $this->importCustomer($customerData, $configId);
                    $this->importCustomerState($customerData, $customer->id);
                }
            }
        }

        return Command::SUCCESS;
    }

    private function importCustomer($customerData, $configId) {
        $stripe_id = '';
        $usage_tracking_id = '';
        return Customer::firstOrCreate([
            'config_id' => $configId,
            'email' => $customerData['email'],
            'stripe_id' => $stripe_id,
            'usage_tracking_id' => $usage_tracking_id,
        ]);
    }

    private function importCustomerState($customerData, $customerID) {
        $states = [
            'funnel_step'=> $customerData['states']['funnel_step'],
            'likelihood'=>$customerData['states']['likelihood'],
            'user_creation_time' => $customerData['states']['user_creation_time'],
            'time_to_value'=> $customerData['states']['time_to_value'],
            'events' => $customerData['states']['events'],
        ];
        CustomerState::create([
            'customer_id' => $customerID,
            'date' => date('Y-m-d H:i:s'),
            'plans' => $customerData['current_plan'],
            'predicted_plan'=>$customerData['predicted_plan'],
            'state' => $states,
        ]);
    }
}
