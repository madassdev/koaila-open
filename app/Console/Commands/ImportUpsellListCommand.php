<?php

namespace App\Console\Commands;

use App\Models\CustomerState;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\CSV;
use Illuminate\Support\Facades\DB;

class ImportUpsellListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        // Path to CSV file containing upsell list
        $csv_file = '/Users/kristellefeghali/Documents/PropheSee/prophesee-analytics/results/notionforms/april2023/06042023-notionforms.csv';

        CSV::foreach($csv_file, function ($row) {

            $event = array();
            for ($i = 3; $i <= 10; $i++) {
                $event[] = $row[$i];
            }

            echo($event);

//            $states = [
//                'plan' => $row[2],
//                'funnel_step'=> $row[1],
//                'events'=>$event,
//            ];

//            CustomerState::insert([
//                'customer_email' => $row[0],
//                'date' => $row[1],
//                'state' => $states,
//            ]);

        });
        return Command::SUCCESS;
    }
}
