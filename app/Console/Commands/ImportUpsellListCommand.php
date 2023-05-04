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
    protected $signature = 'import:upsell-list {config_id} {file_path}';

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
        $csv = [];
        if (Storage::exists($upsell_filePath)) {
            $csv_file = Storage::get($upsell_filePath);
            $rows = preg_split("/\r\n|\n|\r/", $csv_file);
            $headers = str_getcsv(array_shift($rows), ',');
            foreach ($rows as $row) {
                $row = str_getcsv($row, ',');
                if (count($row) === count($headers)) {
                    $csv[] = array_combine($headers, $row);
                }
            }
        }

        $this->withProgressBar($csv, function($row) use ($configId) {
            $customer = $this->importCustomer($row, $configId);
            $this->importCustomerState($row, $customer->id);
        });

        return Command::SUCCESS;
    }

    private function importCustomer($customerData, $configId) {
        return Customer::firstOrCreate([
            'config_id' => $configId,
            'email' => strtolower($customerData['email']),
            'stripe_id' => $customerData['stripe_id'],
            'usage_tracking_id' => intval($customerData['amplitude_id']),
        ]);
    }

    private function importCustomerState($customerData, $customerID) {
        $events=[];
        foreach ($customerData as $key=>$value)
            if(!in_array($key, array('','email','funnel_step','likelihood','user_creation_time','time_to_value','plan')))
                $events[$key] = $value;
        $states = [
            'funnel_step'=> $customerData['funnel step'],
            'likelihood'=>$customerData['likelihood'],
            'user_creation_time' => $customerData['user_creation_time'],
            'time_to_value'=> $customerData['time_to_value'],
            'events' => array_slice($customerData, 7),
        ];
        CustomerState::create([
            'customer_id' => $customerID,
            'email' => strtolower($customerData['email']),
            'date' => date('Y-m-d H:i:s'),
            'plans' => $customerData['plan'],
            'state' => $states,
        ]);
    }
}
