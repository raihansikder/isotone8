<?php

namespace App\Observers;

use App\Module;

class ModuleObserver
{
    /**
     * Handle the base module "created" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function created($element)
    {
        //
    }

    public function updating($element)
    {
        \Session::push('updating','done');
        //
    }

    /**
     * Handle the base module "updated" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function updated($element)
    {
        \Session::push('updated','done');
        //
    }

    public function saving($element) {
        \Session::push('saving','done');
        /** @var Basemodule $element */
        // $element = fillModel($element); // This line should be placed just before return
        // Change::keepChangesInSession($element); // store change log

        //Validate
        /*$validator = $element->validateModel();
        if ($validator->fails()) {
            Session::set('validation_errors', json_decode($validator->messages(), true));
            return setError('Failed update - ' . get_class($element));
        }*/
    }

    /**
     * This function is executed during a model's saving() phase
     * @param $element Superhero
     * @return bool
     */
    public function saved($element) {

        \Session::push('saved','done');
        /** @var Basemodule $element */
        // $element = fillModel($element); // This line should be placed just before return
        // Change::keepChangesInSession($element); // store change log

        //Validate
        /*$validator = $element->validateModel();
        if ($validator->fails()) {
            Session::set('validation_errors', json_decode($validator->messages(), true));
            return setError('Failed update - ' . get_class($element));
        }*/
    }



    /**
     * Handle the base module "deleted" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function deleted($element)
    {
        //
    }

    /**
     * Handle the base module "restored" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function restored($element)
    {
        //
    }

    /**
     * Handle the base module "force deleted" event.
     *
     * @param  \App\Basemodule  $baseModule
     * @return void
     */
    public function forceDeleted($element)
    {
        //
    }
}
