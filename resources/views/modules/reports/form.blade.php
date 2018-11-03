@section('contentHeaderBottom')
    @parent
    {{-- show report view --}}
    @if(isset($report))
        <br/>
        @if($report->is_reportviewer=='Yes')
            <a href="{{Report::getReportUrlFromId($report->id)}}" class="btn btn-sm btn-flat btn-default" type='button'
               target="_blank"><i class="fa fa-eye"></i> View Report </a>
        @endif
    @endif
@stop
<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'superheroes'
 * @var $mod                   Module
 * @var $superhero             Superheroe Object that is being edited
 * @var $element               string 'superhero'
 * @var $spyr_element_editable boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>


{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
@include("form.select-tenant")
{{--name--}}
@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])
{{--code--}}
@include('form.input-text', ['var'=>['name'=>'code','label'=>'Code (system code)', 'container_class'=>'col-sm-4']])
{{--category_name--}}
@include('form.input-text', ['var'=>['name'=>'category_name','label'=>'Category', 'container_class'=>'col-sm-4']])
{{--Type--}}
@include('form.select-array', ['var'=>['name'=>'type','label'=>'Type', 'container_class'=>'col-sm-4','options'=>array_merge([''=>'Select'],kv(Report::$types))]])
{{--Version--}}
@include('form.input-text', ['var'=>['name'=>'version','label'=>'Version', 'container_class'=>'col-sm-2']])
{{--description--}}
@include('form.input-text', ['var'=>['name'=>'description','label'=>'Description', 'container_class'=>'col-sm-10']])
{{--is_reportviewer--}}
@include('form.select-array', ['var'=>['name'=>'is_reportviewer','label'=>'Is report viewer', 'container_class'=>'col-sm-4','options'=>['' => 'Select', 'Yes' => 'Yes', 'No' => 'No']]])
{{--Parameter--}}
@include('form.textarea', ['var'=>['name'=>'parameter','label'=>'Parameter', 'container_class'=>'col-sm-10']])
{{--is_public--}}
@include('form.select-array', ['var'=>['name'=>'is_public','label'=>'Is public', 'container_class'=>'col-sm-4','options'=>['' => 'Select', 'Yes' => 'Yes', 'No' => 'No']]])
<div class="clearfix"></div>
{{--Is Base Report--}}
@include('form.input-checkbox', ['var'=>['name'=>'is_base_report','label'=>'Is base report', 'container_class'=>'col-sm-4']])

@include('form.is_active')
{{-- Form ends --}}

{{-- JS starts: javascript codes go here.--}}
@section('js')
    @parent
    <script type="text/javascript">
        /*******************************************************************/
        // List of functions
        /*******************************************************************/

        // Assigns validation rules during saving (both creating and updating)
        function addValidationRulesForSaving() {
            $("input[name=name]").addClass('validate[required]');
        }
    </script>
    @if(!isset($$element))
        <script type="text/javascript">
            /*******************************************************************/
            // Creating :
            // this is a place holder to write  the javascript codes
            // during creation of an element. As this stage $$element or $superhero(module
            // name singular) is not set, also there is no id is created
            // Following the convention of spyrframe you are only allowed to call functions
            /*******************************************************************/

            // your functions go here
            // function1();
            // function2();

        </script>
    @else
        <script type="text/javascript">
            /*******************************************************************/
            // Updating :
            // this is a place holder to write  the javascript codes that will run
            // while updating an element that has been already created.
            // during update the variable $$element or $superhero(module
            // name singular) is set, and id like other attributes of the element can be
            // accessed by calling $$element->id, also $superhero->id
            // Following the convention of spyrframe you are only allowed to call functions
            /*******************************************************************/

            // your functions go here
            // function1();
            // function2();
        </script>
    @endif
    <script type="text/javascript">
        /*******************************************************************/
        // Saving :
        // Saving covers both creating and updating (Similar to Eloquent model event)
        // However, it is not guaranteed $$element is set. So the code here should
        // be functional for both case where an element is being created or already
        // created. This is a good place for writing validation
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions goe here
        // function1();
        // function2();

        /*******************************************************************/
        // frontend and Ajax hybrid validation
        /*******************************************************************/
        addValidationRulesForSaving(); // Assign validation classes/rules
        enableValidation('{{$module_name}}'); // Instantiate validation function

        // Run the function initially when page is loaded
        enableConditionalFields();
        $('select[name=is_reportviewer]').on('change', enableConditionalFields);

        function enableConditionalFields() {
            $('#parameter, .jasper').prop("disabled", true); // Disable fields.
            if ($('select[name=is_reportviewer]').val() === 'Yes') $('#parameter').prop("disabled", false);
        }

    </script>
@stop
{{-- JS ends --}}