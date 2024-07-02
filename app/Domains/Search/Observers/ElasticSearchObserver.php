<?php

namespace App\Domains\Search\Observers;

class ElasticSearchObserver
{
    public function saved($model): void
    {
        $model->elasticSearchIndex();
    }

    public function deleted($model): void
    {
        $model->elasticSearchDelete();
    }
}
