<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class GlobalObserver
{
    public function creating($model)
    {
        if (method_exists($model, 'getCreatedByColumn')) {
            $createdByColumn = $model->getCreatedByColumn();
            $model->$createdByColumn = Auth::id();
        }

        if (method_exists($model, 'getUpdatedByColumn')) {
            $updatedByColumn = $model->getUpdatedByColumn();
            $model->$updatedByColumn = Auth::id();
        }
    }

    public function updating($model)
    {
        if (method_exists($model, 'getUpdatedByColumn')) {
            $updatedByColumn = $model->getUpdatedByColumn();
            $model->$updatedByColumn = Auth::id();
        }
    }
}
