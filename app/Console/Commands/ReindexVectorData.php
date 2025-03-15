<?php

namespace App\Console\Commands;

use App\Domains\AI\Jobs\ReindexVectorDataJob;
use Illuminate\Console\Command;

class ReindexVectorData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reindex-vector-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex all data in the vector database';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        ReindexVectorDataJob::dispatch();
    }
}
