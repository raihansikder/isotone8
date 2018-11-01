<?php

namespace App\Observers;

use App\BaseModule;

class BaseModuleObserver
{
    /**
     * Handle the base module "created" event.
     *
     * @param  \App\BaseModule  $baseModule
     * @return void
     */
    public function created(BaseModule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "updated" event.
     *
     * @param  \App\BaseModule  $baseModule
     * @return void
     */
    public function updated(BaseModule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "deleted" event.
     *
     * @param  \App\BaseModule  $baseModule
     * @return void
     */
    public function deleted(BaseModule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "restored" event.
     *
     * @param  \App\BaseModule  $baseModule
     * @return void
     */
    public function restored(BaseModule $baseModule)
    {
        //
    }

    /**
     * Handle the base module "force deleted" event.
     *
     * @param  \App\BaseModule  $baseModule
     * @return void
     */
    public function forceDeleted(BaseModule $baseModule)
    {
        //
    }
}
