<?php

namespace App\Console\Commands\Exchange;

use App\Services\Exchange\Exception\CannotCreateDirectoryByPath;
use App\Services\Exchange\Exception\NoDirectoryByPath;
use App\Services\Exchange\Locker\LockerException;
use App\Services\Exchange\Logger\ImportLogger;
use App\Services\Exchange\Runner\ImportRunner;
use Illuminate\Console\Command;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:exchange:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from 1c';

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
     * @param ImportLogger $logger
     */
    public function handle(ImportLogger $logger)
    {
        try {
            $importRunner = resolve(ImportRunner::class);
            $importRunner->run();
        } catch (NoDirectoryByPath | CannotCreateDirectoryByPath | LockerException $e) {
            $this->error($e->getMessage());
            $logger->addErrorLog($e->getMessage());
        }
    }
}
