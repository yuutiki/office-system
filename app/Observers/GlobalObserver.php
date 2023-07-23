<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class GlobalObserver
{
    public function __invoke($model)
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
