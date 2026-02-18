<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    public function created(Model $model): void
    {
        AuditLog::log('created', class_basename($model), $model->id, null, $model->toArray());
    }

    public function updated(Model $model): void
    {
        $original = $model->getOriginal();
        $changed = $model->getChanges();

        // Skip if only timestamps changed
        $nonTimestampChanges = collect($changed)->except(['updated_at', 'created_at'])->toArray();
        if (empty($nonTimestampChanges)) {
            return;
        }

        AuditLog::log('updated', class_basename($model), $model->id, $original, $changed);
    }

    public function deleted(Model $model): void
    {
        AuditLog::log('deleted', class_basename($model), $model->id, $model->toArray(), null);
    }
}
