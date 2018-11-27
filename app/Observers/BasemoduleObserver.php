<?php

namespace App\Observers;

class BasemoduleObserver
{

    public function saving($element)
    {
        /** @var Basemodule $element */
        $element = fillModel($element); // This line should be placed just before return
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
     *
     * @param $element Superhero
     * @return bool
     */
    public function saved($element)
    {

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
     * @param  $element
     * @return void
     */
    public function deleted($element)
    {
        //
    }

    /**
     * Handle the base module "restored" event.
     *
     * @param  $element
     * @return void
     */
    public function restored($element)
    {
        //
    }

    /**
     * Handle the base module "force deleted" event.
     *
     * @param  $element
     * @return void
     */
    public function forceDeleted($element)
    {
        //
    }
}
