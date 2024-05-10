<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tlab\TransferObjects\DataTransferBuilder;

class GenerateTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate data transfer objects';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataTransferDirectory = dirname(__DIR__, 2) . '/DataTransfers/';
        $dataTransferBuilder = new DataTransferBuilder(
            $dataTransferDirectory . 'Definitions',
            $dataTransferDirectory .  'DataTransferObjects',
            'App\\DataTransfers\\DataTransferObjects',
        );
        $dataTransferBuilder->build();
    }
}
