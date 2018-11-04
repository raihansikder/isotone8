<?php

namespace App\Observers;

use App\Basemodule;

class BaseModuleObserver
{
    /**
     * Handle the base module "created" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function created(Basemodule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "updated" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function updated(Basemodule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "deleted" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function deleted(Basemodule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "restored" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function restored(Basemodule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "force deleted" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function forceDeleted(Basemodule $baseModule)
    {
        //
    }
}
