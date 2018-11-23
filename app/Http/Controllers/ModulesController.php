<?php

namespace App\Http\Controllers;


class ModulesController extends ModulebaseController
{

    /*
     * constructor
     */

    public function __construct()
    {
        $this->module_name = controllerModule(get_class());
        parent::__construct($this->module_name);
    }
}
