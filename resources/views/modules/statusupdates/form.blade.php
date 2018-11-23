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
{{--module_id--}}
@include('form.select-model',['var'=>['name'=>'module_id','label'=>'Module name', 'table'=>'modules', 'container_class'=>'col-sm-3']])

{{--element_id--}}
@include('form.input-text',['var'=>['name'=>'element_id','label'=>'Element Id', 'container_class'=>'col-sm-3']])

{{--status_id_field--}}
@include('form.input-text',['var'=>['name'=>'status_id_field','label'=>'Status id field', 'container_class'=>'col-sm-3']])

{{--status_name_field--}}
@include('form.input-text',['var'=>['name'=>'status_name_field','label'=>'Status name field', 'container_class'=>'col-sm-3']])

{{--status_id--}}
@include('form.input-text',['var'=>['name'=>'status_id','label'=>'Status id', 'container_class'=>'col-sm-3']])

{{--status_name--}}
@include('form.input-text',['var'=>['name'=>'status_name','label'=>'Status name', 'container_class'=>'col-sm-3']])

{{--event--}}
@include('form.input-text',['var'=>['name'=>'event','label'=>'Event', 'container_class'=>'col-sm-3']])

{{-- note --}}
@include('form.textarea',['var'=>['name'=>'note','label'=>'Note', 'container_class'=>'col-sm-10']])


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

        $('option:not(:selected)').attr('disabled', true).remove(); // remove all options that are not selected
        $('input').attr('readonly', 'readonly'); // make everything readonly
    </script>
@endsection
{{-- JS ends --}}