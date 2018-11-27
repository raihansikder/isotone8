<?php

namespace App\Http\Controllers;

use App\Module;
use DB;
use Redirect;
use Request;
use Response;
use Validator;
use View;

/**
 * Class ModulebaseController
 */
class ModulebaseController extends Controller
{
    protected $module_name;         // Stores module name with lowercase and plural i.e. 'superheros'.
    protected $grid_query;          // Stores default DB query to create the grid. Used in grid() function.
    protected $grid_columns;        // Columns to show, this array is set form modules individual controller.
    protected $report_data_source = null;  // loads the model name

    /**
     * Constructor for this class is very important as it boots up necessary features of
     * Spyr module. First of all, it load module related meta information, then based
     * on context check(tenant context) it loads the tenant id. The it constructs the default
     * grid query and also add tenant context to grid query if applicable. Finally it
     * globally shares a couple of variables $module_name, $mod to all views rendered
     * from this controller
     *
     * @param $module_name
     */
    public function __construct($module_name)
    {
        $this->module_name = $module_name;

        // Default grid SQL select and column titles.
        if (!isset($this->grid_columns)) {
            $this->grid_columns = [
                //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid colum header
                [$this->module_name . '.id', 'id', 'ID'],
                [$this->module_name . '.name', 'name', 'Name'],
                ['updater.name', 'user_name', 'Updater'],
                [$this->module_name . '.updated_at', 'updated_at', 'Updated at'],
                [$this->module_name . '.is_active', 'is_active', 'Active']
            ];
        }
        # Inject tenant context in grid query
        if ($tenant_id = inTenantContext($module_name)) {
            Input::merge([tenantIdField() => $tenant_id]); // Set tenant_id in request header
        }


        // Share the variables across all views accessed by this controller
        View::share([
            'module_name' => $this->module_name,
            'mod' => Module::whereName($this->module_name)->remember(cacheTime('long'))->first()
        ]);
    }

    /**
     * Index/List page to show grid
     * This controller method is responsible for rendering the view that has the default
     * spyr module grid.
     *
     * @return \App\Http\Controllers\ModulebaseController|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (hasModulePermission($this->module_name, 'view-list')) {
            if (Request::get('ret') == 'json') {
                return self::getJson();
            }
            $view = 'modules.base.grid';
            if (View::exists('modules.' . $this->module_name . '.grid')) {
                $view = 'modules.' . $this->module_name . '.grid';
            }
            return view($view)->with('grid_columns', $this->grid_columns);
        } else {
            return View::make('template.blank')
                ->with('title', 'Permission denied!')
                ->with('body', "You don't have permission [ " . $this->module_name . ".view-list]");
        }
    }

    /**
     * Returns datatable json for the module index page
     * A route is automatically created for all modules to access this controller function
     *
     * @return mixed
     */
    public function grid()
    {
        // Prepare colum selection for grid.
        $select_cols = [];
        foreach ($this->grid_columns as $col)
            $select_cols[] = $col[0] . ' as ' . $col[1];

        # load default grid query
        if (!isset($this->grid_query)) {
            $this->grid_query = DB::table($this->module_name)
                ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
                ->select($select_cols);
        }
        # Inject tenant context in grid query
        if ($tenant_id = inTenantContext($this->module_name)) {
            $this->grid_query = injectTenantIdInModelQuery($this->module_name, $this->grid_query);
        }

        // Grid query builder
        $this->grid_query = $this->grid_query->whereNull($this->module_name . '.deleted_at'); // Skip deleted rows

        // Make datatable
        /** @var \Yajra\DataTables\DataTables $dt */
        $dt = datatables($this->grid_query);
        $dt = $dt->editColumn('name', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$name}}</a>');
        $dt = $dt->editColumn('is_active', '@if($is_active)  Yes @else <span class="text-red">No</span> @endif');

        // Columns for  HTML rendering
        $dt = $dt->rawColumns(['name', 'is_active']); // HTML can be printed for raw columns

        return $dt->toJson();
    }

    /**
     * Shows an element create form.
     *
     * @return view
     */
    public function create()
    {
        if (hasModulePermission($this->module_name, 'create')) { // check for create permission
            $uuid = (Request::old('uuid')) ? Request::old('uuid') : uuid(); // Set uuid for the new element to be created
            return View::make('modules.base.form')->with('uuid', $uuid)->with('spyr_element_editable', true);
        } else {
            return View::make('template.blank')
                ->with('title', 'Permission denied!')
                ->with('body', "You don't have permission [ " . $this->module_name . ".create]");
        }
    }

    /**
     * Store an spyr element. Returns json response if ret=json is sent as url parameter. Otherwise redirects
     * based on the url set in redirect_success|redirect_fail
     *
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        $module_name = $this->module_name;
        $Model = model($this->module_name);

        //$element_name = str_singular($module_name);
        //$ret = ret();
        # --------------------------------------------------------
        # Process store while creation
        # --------------------------------------------------------
        if (hasModulePermission($this->module_name, 'create')) { // check module permission
            $element = new $Model(Request::all());
            $validator = Validator::make(Request::all(), $Model::rules($element), $Model::$custom_validation_messages);

            // $element = new $Model;
            // $element->fill(Request::all());
            // $validator = $element->validateModel();

            if ($validator->fails()) {
                $ret = ret('fail', "Validation error(s) on creating $Model.", ['validation_errors' => json_decode($validator->messages(), true)]);
            } else {
                if ($element->isCreatable()) {
                    if ($element->save()) {
                        //$ret = ret('success', "$Model " . $element->id . " has been created", ['data' => $Model::find($element->id)]);
                        $ret = ret('success', "$Model has been added", ['data' => $Model::find($element->id)]);
                        //Upload::linkTemporaryUploads($element->id, $element->uuid);
                    } else {
                        $ret = ret('fail', "$Model create failed.");
                    }
                } else {
                    $ret = ret('fail', "$Model could not be saved. (error: isCreatable())");
                }
            }
        } else {
            $ret = ret('fail', "User does not have create permission for $Model ");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') == 'json') {
            // fill with session values(messages, errors, success etc) and redirect
            $ret = fillRet($ret);
            if ($ret['status'] == 'success' && (isset($ret['redirect']) && $ret['redirect'] == '#new')) {
                $ret['redirect'] = route("$module_name.edit", $element->id);
            }
            return Response::json($ret);
        } else {
            if ($ret['status'] == 'fail') {
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                $redirect = Request::has('redirect_fail') ? Redirect::to(Request::get('redirect_fail')) : Redirect::back();

                // Include Inputs and Validation errors in redirection.
                $redirect = $redirect->withInput();
                if (isset($validator)) $redirect = $redirect->withErrors($validator);

            } else {
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                if (Request::has('redirect_success')) {
                    $redirect = Request::get('redirect_success') == '#new' ? Redirect::route("$module_name.edit", $element->id)
                        : Redirect::to(Request::get('redirect_success'));
                } else {
                    $redirect = Redirect::back();
                }
            }

            return $redirect;
        }
    }

    /**
     * Shows an spyr element. Store an spyr element. Returns json response if ret=json is sent as url parameter.
     * Otherwise redirects to edit page where details is visible as filled up edit form.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        $module_name = $this->module_name;
        $Model = model($this->module_name);
        //$element_name = str_singular($module_name);
        //$ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process show
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if the element exists
            if ($element->isViewable()) { // Check if the element is viewable
                //$ret = ret('success', "$Model " . $element->id . " found", ['data' => $element]);
                $ret = ret('success', "", ['data' => $element]);
            } else { // not viewable
                $ret = ret('fail', "$Model is not viewable.");
            }
        } else { // The element was not found or has been deleted.
            $ret = ret('fail', "$Model could not be found. The element is either unavailable or deleted.");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') == 'json') {
            return Response::json(fillRet($ret));
        } else {
            if ($ret['status'] == 'fail') { // Show failed. Redirect to fail path(url)
                return Redirect::route('home');
            } else { // Redirect to edit path
                return Redirect::route("$module_name.edit", $id);
            }
        }
    }

    /**
     * Show spyr element edit form
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        $module_name = $this->module_name;
        $Model = model($this->module_name);
        $element_name = str_singular($module_name);
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if the element you are trying to edit exists
            if ($element->isViewable()) { // Check if the element is viewable
                return View::make('modules.base.form')
                    ->with('element', $element_name)//loads the singular module name in variable called $element = 'user'
                    ->with($element_name, $element)//loads the object into a variable with module name $user = (user object)
                    ->with('spyr_element_editable', $element->isEditable());
            } else { // Not viewable by the user. Set error message and return value.
                //return showPermissionErrorPage("The element is not view-able by current user.");
                return View::make('template.blank')
                    ->with('title', 'Permission denied!')
                    ->with('body', "The element is not view-able by current user. [ Error :: isViewable()]");
            }
        } else { // The element does not exist. Set error and return values
            //return showGenericErrorPage("The item that you are trying to access does not exist or has been deleted");
            return View::make('template.blank')
                ->with('title', 'Not found!')
                ->with('body', "The item that you are trying to access does not exist or has been deleted");
        }
    }

    /**
     * Update handler for spyr element.
     *
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {

        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        //$module_name = $this->module_name;
        $Model = model($this->module_name);
        // $element_name = str_singular($module_name);
        // $ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process update
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if element exists.
            if ($element->isEditable()) { // Check if the element is editable.
                $element->fill(Request::all());
                $validator = $element->validateModel();
                if ($validator->fails()) {
                    $ret = ret('fail', "Validation error(s) on updating $Model.", ['validation_errors' => json_decode($validator->messages(), true)]);
                } else {
                    if ($element->fill(Request::all())->save()) { // Attempt to update/save.
                        $ret = ret('success', "$Model has been updated", ['data' => $element]);
                    } else { // attempt to update/save failed. Set error message and return values.
                        $ret = ret('fail', "$Model update failed.");
                    }
                }

            } else { // Element is not editable. Set message and return values.
                $ret = ret('fail', "$Model is not editable by user.");
            }
        } else { // element does not exist(or possibly deleted). Set error message and return values
            $ret = ret('fail', "$Model could not be found. The element is either unavailable or deleted.");
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

    /**
     * Delete spyr element.
     *
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        // $module_name = $this->module_name;
        $Model = model($this->module_name);
        // $element_name = str_singular($module_name);
        // $ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process delete
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // check if the element exists
            if ($element->isDeletable()) { // check if the element is editable
                if ($element->delete()) { // attempt delete and set success message return values
                    $ret = ret('success', "$Model has been deleted");
                } else { // handle delete failure and set error message and return values
                    $ret = ret('fail', "$Model delete failed.");
                }
            } else { // element is not editable(which also means not deletable)
                $ret = ret('fail', "$Model could not be deleted.");
            }
        } else { // the element was not fonud. Set error message and return value
            $ret = ret('fail', "$Model could not be found. The element is either unavailable or deleted.");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') == 'json') {
            return Response::json($ret = fillRet($ret));
        } else {
            if ($ret['status'] == 'fail') { // Delete failed. Redirect to fail path(url)
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                $redirect = Request::has('redirect_fail') ? Redirect::to(Request::get('redirect_fail')) : Redirect::back();
            } else { // Delete successful. Redirect to success path(url)
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                if (Request::has('redirect_success')) $redirect = Redirect::to(Request::get('redirect_success'));
                else {
                    return View::make('template.blank')
                        ->with('title', 'Delete success!')
                        ->with('body', "The item that you are trying to access does not exist or has been deleted");
                }
            }
            return $redirect;
        }
    }

    /**
     * Restore a soft-deleted.
     *
     * @param null $id
     * @return $this
     */
    public function restore($id = null)
    {
        //return showGenericErrorPage("[$id] can not be restored. Restore feature is disabled");
        return View::make('template.blank')
            ->with('title', 'Restore not allowed')
            ->with('body', "The item can not be restored");
    }

    /**
     * Returns a collection of objects as Json
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJson()
    {
        $Model = model($this->module_name);

        /** @var \App\Basemodule $Model */
        /** @var \Illuminate\Database\Eloquent\Model $q */
        $q = $Model::where('is_active', 1);
        $q = self::filterQueryConstructor($q);

        $total = $q->count();

        # set offset
        // $q = self::filterQueryConstructorAddLimit($q);
        $offset = 0;
        if (Request::has('offset')) {
            $offset = Request::get('offset');
            $q = $q->skip($offset);
        }
        #set limit
        $limit = $max_limit = 20;
        if (Request::has('limit')) {
            if (Request::get('limit') <= $max_limit) {
                $limit = Request::get('limit');
            }
        }
        $q = $q->take($limit);
        $data = $q->remember(cacheTime('getJson'))->get();

        # prepare json response
        $ret = ret('success', "", compact('data', 'total', 'offset', 'limit'));
        return Response::json(fillRet($ret));
    }

    /**
     * Json return query constructor
     *
     * @param $q
     * @return \App\Basemodule
     */
    public function filterQueryConstructor($q)
    {
        $Model = model($this->module_name);
        //$module_sys_name = $this->module_name;

        /** @var \App\Basemodule $q */
        /** @var \App\Basemodule $Model */
        // $q = $q->where('is_active', 1);

        if (inTenantContext($this->module_name)) {
            $q = injectTenantIdInModelQuery($this->module_name, $q);
        }

        # Generic API return
        if (Request::has('updatedSince')) $q = $q->where('updated_at', '>=', Request::get('updatedSince'));
        if (Request::has('createdSince')) $q = $q->where('created_at', '>=', Request::get('createdSince'));
        if (Request::has('updatedAt')) $q = $q->whereRaw("DATE(updated_at) = " . "'" . Request::get('updateddAt') . "'");
        if (Request::has('createdAt')) $q = $q->whereRaw("DATE(created_at) = " . "'" . Request::get('createdAt') . "'");

        if (Request::has('fieldName') && Request::has('fieldValue')) {
            $fieldName = Request::get('fieldName');
            $fieldValue = Request::get('fieldValue');
            $q = $q->where($fieldName, $fieldValue);
        }

        $q_fields = getModelFields($Model);
        foreach (Request::all() as $name => $val) {
            if (in_array($name, $q_fields)) {
                if (is_array($val) && count($val)) {
                    $temp = removeEmptyVals($val);
                    if (count($temp)) $q = $q->whereIn($name, $temp);
                } else if (strlen($val) && strstr($val, ',')) {
                    $q = $q->whereIn($name, explode(',', $val));
                } else if (strlen($val)) {
                    $q = $q->where($name, $val);
                }
            }
        }
        #sort field
        if (Request::has('sort_by')) {
            $sort_by = Request::get('sort_by');
            $q = $q->orderBy($sort_by, 'ASC');
        }
        # set offset
        /*if (Request::has('offset')) $q = $q->skip(Request::get('offset'));
        #set limit
        $limit = $max_limit = 20;
        if (Request::has('limit')) {
            if (Request::get('limit') <= $max_limit) {
                $limit = Request::get('limit');
            }
        }
        $q = $q->take($limit);*/

        return $q;

    }
    /*public function filterQueryConstructorAddLimit($q) {
        # set offset
        if (Request::has('offset')) $q = $q->skip(Request::get('offset'));
        #set limit
        $limit = $max_limit = 20;
        if (Request::has('limit')) {
            if (Request::get('limit') <= $max_limit) {
                $limit = Request::get('limit');
            }
        }
        $q = $q->take($limit);

        return $q;
    }*/

    /**
     * Show all the changes/change logs of an item
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|ModulebaseController
     */
    public function changes($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        $module_name = $this->module_name;
        $Model = model($this->module_name);
        $element_name = str_singular($module_name);
        //$ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if the element you are trying to edit exists
            if ($element->isViewable()) { // Check if the element is viewable
                $changes = $element->changes;
                $ret = ret('success', "", ['data' => $changes]);
            } else { // Not viewable by the user. Set error message and return value.
                $ret = ret('fail', "The element is not view-able by current user.");
                //return showPermissionErrorPage("The element is not view-able by current user.");
            }
        } else { // The element does not exist. Set error and return values
            $ret = ret('fail', "The item that you are trying to access does not exist or has been deleted");
            //return showGenericErrorPage("The item that you are trying to access does not exist or has been deleted");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') == 'json') {
            return Response::json(fillRet($ret));
        } else {
            if ($ret['status'] == 'fail') { // Update failed. Redirect to fail path(url)
                return showGenericErrorPage($ret['message']);
            } else { // Update successful. Redirect to success path(url)
                /** @var array $changes */
                return View::make('modules.base.changes')
                    ->with('element', $element_name)
                    ->with($element_name, $element)
                    ->with('changes', $changes);
            }
        }
    }

    /**
     * Module generic report
     *
     * @return \App\Http\Controllers\JsonResponse|bool|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function report()
    {

        if (hasModulePermission($this->module_name, 'report')) {
            # Report source table/view
            if (!$this->report_data_source) { // If no source(view/table) is set in Module controller set the default table.
                $this->report_data_source = DB::getTablePrefix() . $this->module_name;
            }
            /** @var string $data_source SQL view/table full name */
            $data_source = $this->report_data_source; // Define data source
            /***************************************************/

            /** @var  $result_path  Define path to results view */
            $result_path = "modules.base.report.results"; // Define result path
            // Override default if a module specific report blade exists in location  "{module_name}.report.result"
            $module_report_view_path = $this->module_name . ".report.results";
            if (View::exists($module_report_view_path)) $result_path = $module_report_view_path;

            // Again override if a tenant specific result blade exists in "{module_name}.{tenant_id.}report.result"
            if (userTenantId()) {
                $tenant_report_view_path = $this->module_name . "." . userTenantId() . ".report.results";
                if (View::exists($tenant_report_view_path)) $result_path = $tenant_report_view_path;
            }
            /***************************************************/

            if (Request::has('submit') && Request::get('submit') == 'Run') {

                /** @var string $fields_csv_esc Select fields enclosed in escape character (`) */
                $fields_csv_esc = Reportbuilder::fieldsEscCsv(Reportbuilder::fields());

                /** @var array $data_source_fields Fields of data source (SQL table, view) */
                $data_source_fields = Reportbuilder::dataSourceFields($data_source);

                /***********************************************
                 * Customize : Over-ride this custom query builder for
                 * handling special fields. i.e. date range etc.
                 ***********************************************/
                /** @var string $filters SQL where clause */
                $filters = Reportbuilder::sqlFiltersFromInputs($data_source_fields);

                /***************************************************************************/
                // Based on currently logged in user type further narrow down the query
                // by adding tenant context or facility context.
                /***************************************************************************/
                if ($user = user()) {
                    if (userTenantId() && in_array(tenantIdField(), $data_source_fields)) {
                        $filters .= " AND " . tenantIdField() . "='" . userTenantId() . "' ";
                    }
                }
                /***********************************************/

                /** @var string $group_by Group By string */
                $group_by = Reportbuilder::groupBy();
                /***********************************************
                 * Customize : Over-ride this for cases where more fields are required to show. i.e. male, female count in
                 * sanctioned post report.
                 ***********************************************/
                // Add count field (Total) to select fields.
                if (strlen(trim($group_by))) $fields_csv_esc .= " , count(*) AS 'total' ";

                /***************************************************************************/
                // Result
                /***************************************************************************/
                /** @var array $ret compact('results', 'sql', 'total', 'pagination') */
                $ret = Reportbuilder::query($data_source, $fields_csv_esc, $filters, $group_by);

                /***************************************************************************/
                // Output
                /***************************************************************************/
                return Reportbuilder::render($ret, $result_path);

            } else {
                return View::make($result_path);
            }
        } else {
            return View::make('master.blank')->with('title', 'Permission denied!')
                ->with('body', "You don't have permission [ " . $this->module_name . ".report]");
        }
    }
}
