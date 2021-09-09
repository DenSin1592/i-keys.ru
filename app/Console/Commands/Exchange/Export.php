<?php

namespace App\Console\Commands\Exchange;

use App\Services\Exchange\Exception\CannotCreateDirectoryByPath;
use App\Services\Exchange\Exception\NoDirectoryByPath;
use App\Services\Exchange\Locker\LockerException;
use App\Services\Exchange\Logger\ExportLogger;
use App\Services\Exchange\Runner\ExportRunner;
use Illuminate\Console\Command;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:exchange:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export data to 1c';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param ExportLogger $logger
     */
    public function handle(ExportLogger $logger)
    {
        try {
            $exportRunner = resolve(ExportRunner::class);
            $exportRunner->run();
        } catch (NoDirectoryByPath | CannotCreateDirectoryByPath | LockerException $e) {
            $this->error($e->getMessage());
            $logger->addErrorLog($e->getMessage());
        }
    }
}
