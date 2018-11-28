<?php

namespace App\Http\Controllers;

use App\Module;
use DB;
use Redirect;
use Request;
use Response;
use Validator;
use View;

class SuperheroesController extends ModulebaseController
{

    /*
     * constructor
     */
    public function __construct()
    {
        $this->module_name = controllerModule(get_class());

        // Uncomment the following to define your own grid.
        // Also you can customize grid() function.
        // ***************************************************

        // // Define grid SELECT statment and HTML column name.
        // $this->grid_columns = [
        //     //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid colum header
        //     ["{$this->module_name}.id", "id", "ID"],
        //     ["{$this->module_name}.name", "name", "Name"],
        //     ["updater.name", "user_name", "Updater"],
        //     ["{$this->module_name}.updated_at", "updated_at", "Updated at"],
        //     ["{$this->module_name}.is_active", "is_active", "Active"]
        // ];
        //
        // // Construct SELECT statment
        // $select_cols = [];
        // foreach ($this->grid_columns as $col)
        //     $select_cols[] = $col[0] . ' as ' . $col[1];
        //
        // // Define Query for generating results for grid
        // $this->grid_query = \DB::table($this->module_name)
        //     ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
        //     ->select($select_cols);
        // ***************************************************

        parent::__construct($this->module_name);
    }


    // Custom grid function boilerplate.
    // ***************************************************
    /**
     * Returns datatable json for the module index page
     * A route is automatically created for all modules to access this controller function
     *
     * @var \Yajra\DataTables\DataTables $dt
     * @return mixed
     */
    // public function grid()
    // {
    //     // Construct SELECT statment
    //     $select_cols = [];
    //     foreach ($this->grid_columns as $col)
    //         $select_cols[] = $col[0] . ' as ' . $col[1];
    //
    //     // Define Query for generating results for grid
    //     if (!isset($this->grid_query)) {
    //         $this->grid_query = \DB::table($this->module_name)
    //             ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
    //             ->select($select_cols);
    //     }
    //     // Inject tenant context in grid query
    //     if ($tenant_id = inTenantContext($this->module_name)) {
    //         $this->grid_query = injectTenantIdInModelQuery($this->module_name, $this->grid_query);
    //     }
    //
    //     // Exclude deleted rows
    //     $this->grid_query = $this->grid_query->whereNull($this->module_name . '.deleted_at');
    //
    //     // Make datatable
    //     $dt = datatables($this->grid_query);
    //     $dt = $dt->editColumn('name', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$name}}</a>');
    //     $dt = $dt->editColumn('is_active', '@if($is_active)  Yes @else <span class="text-red">No</span> @endif');
    //
    //     // Columns for  HTML rendering
    //     $dt = $dt->rawColumns(['name', 'is_active']);
    //
    //     return $dt->toJson();
    // }
    // ***************************************************
}
