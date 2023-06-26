<?php

namespace App\Console\Commands;

use App\Models\Configuration;
use App\Models\SaleFunnel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportSaleFunnelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'import:sale-funnel {config_id} {file_path}';


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
            $saleFunnel = json_decode(Storage::get($upsell_filePath), true);
            SaleFunnel::create([
                'config_id'=>$this->argument('config_id'),
                'data'=>$saleFunnel
            ]);
        }
        return Command::SUCCESS;
    }
}
