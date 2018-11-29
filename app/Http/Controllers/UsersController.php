<?php

namespace App\Http\Controllers;

use App\Module;
use DB;
use Redirect;
use Request;
use Response;
use Validator;
use View;

class UsersController extends ModulebaseController
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

    /**
     * User update. Modulebase controller function had to be overridden so that we can handle the password related
     * validations separately.
     *
     * @param $id
     * @var \App\Basemodule $Model
     * @var \App\Basemodule $element
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        // init local variables
        $Model = model($this->module_name);
        # --------------------------------------------------------
        # Process update
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if element exists.
            if ($element->isEditable()) { // Check if the element is editable.

                // Validate
                $password = Request::get('password');
                $validator = Validator::make(Request::all(), $Model::rules($element), $Model::$custom_validation_messages);

                //$validator = $element->validateModel();
                if ($validator->fails()) {
                    $ret = ret('fail', "Validation error(s) on updating {$this->module->title}.", ['validation_errors' => json_decode($validator->messages(), true)]);
                } else {

                    $element->fill(Request::except(['password']));
                    if ($password) $element->password = $password;

                    if ($element->save()) { // Attempt to update/save.
                        $ret = ret('success', "{$this->module->title} has been updated", ['data' => $element]);
                    } else { // attempt to update/save failed. Set error message and return values.
                        $ret = ret('fail', "{$this->module->title} update failed.");
                    }
                }

            } else { // Element is not editable. Set message and return values.
                $ret = ret('fail', "{$this->module->title} is not editable by user.");
            }
        } else { // element does not exist(or possibly deleted). Set error message and return values
            $ret = ret('fail', "{$this->module->title} could not be found. The element is either unavailable or deleted.");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') == 'json') {
            return Response::json(fillRet($ret));
        } else {
            if ($ret['status'] == 'fail') { // Update failed. Redirect to fail path(url)
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                $redirect = Request::has('redirect_fail') ? Redirect::to(Request::get('redirect_fail')) : Redirect::back();
                // Include Inputs and Validation errors in redirection.
                $redirect = $redirect->withInput();
                if (isset($validator)) $redirect = $redirect->withErrors($validator);
            } else {
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                $redirect = Request::has('redirect_success') ? Redirect::to(Request::get('redirect_success')) : Redirect::back();
            }
            return $redirect;
        }
    }
}
