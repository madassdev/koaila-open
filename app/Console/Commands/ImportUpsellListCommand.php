<?php

namespace App\Console\Commands;

use App\Models\CustomerState;
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
    protected $signature = 'import:upsell:list';

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
        $user_id = '4';
        // Path to CSV file containing upsell list
        $upsell_filePath = "/results/notionforms.csv";
        $csv = array();
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

        foreach ($csv as $row){
            $states = [
                'plan' => $row['plan'],
                'funnel_step'=> $row['funnel step'],
                'likelihood'=>$row['likelihood'],
                'user_creation_time' => $row['user_creation_time'],
                'time_to_value'=> $row['time_to_value'],
                'events' => array_slice($row, 7),
            ];
            CustomerState::create([
                'user_id' => $user_id,
                'customer_email' => $row['email'],
                'date' => date('Y-m-d H:i:s'),
                'state' => $states,
            ]);
        }
        return Command::SUCCESS;
    }
}
