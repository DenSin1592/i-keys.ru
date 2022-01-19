<?php

namespace App\Console\Commands\Products;

use App\Models\Product;
use Illuminate\Console\Command;


class RefreshNamesWithAttributes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:products:refresh-names-with-attributes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh name with attributes for each products';

    public function handle()
    {
        $total = Product::count();
        $progressBar = $this->output->createProgressBar($total);

        $chunkSize = 100;
        Product::chunk($chunkSize, static function ($chunk) use ($progressBar, $chunkSize) {
            foreach ($chunk as $product) {
                $product->refreshNameWithAttributes();
            }
            $progressBar->advance($chunkSize);
        });

        $progressBar->finish();
        $this->info('');
    }
}
