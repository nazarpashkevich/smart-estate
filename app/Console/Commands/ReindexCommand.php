<?php

namespace App\Console\Commands;

use App\Domains\Estate\Models\EstateItem;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    const INDEXABLE_MODELS = [
        EstateItem::class,
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all records to Elasticsearch';

    public function handle(): void
    {
        $this->info('Indexing all records. This might take a while...');

        foreach (self::INDEXABLE_MODELS as $model) {
            /**
             * @var \App\Domains\Search\Contracts\Model\ElasticSearchable $item
             */
            foreach ($model::cursor() as $item) {
                $item->elasticsearchIndex();

                $this->comment("Indexed {$model}::{$item->getQueueableId()}");
            }
        }

        $this->info("\nDone!");
    }
}
