<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
// use Illuminate\Database\Eloquent\Model;

class GlobalObserver
{
    public function __invoke($model)
    {

    }

    public function creating($model)
    {
        $model->created_by = Auth::id();
        $model->updated_by = Auth::id();
    }

    public function updating($model)
    {
        $model->updated_by = Auth::id();
    }
}
