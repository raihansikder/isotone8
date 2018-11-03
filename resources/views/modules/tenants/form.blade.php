<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name string 'tenants'
 * @var $mod Module
 * @var $tenant Tenant Object that is being edited
 * @var $element string 'tenant'
 * @var $spyr_element_editable boolean
 * @var $uuid string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>

{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])
@include('form.input-text',['var'=>['name'=>'code','label'=>'Access code', 'container_class'=>'col-sm-2']])
@include('form.input-text',['var'=>['name'=>'theme_color','label'=>'Theme color (HEX)', 'container_class'=>'col-sm-2']])
{{--@include('form.input-hidden',['var'=>['name'=>'user_id']])--}}
@include('form.is_active')
{{-- Form ends--}}

@section('content-bottom')
    @parent
    <h4>Logo</h4>
    @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>1,'limit'=>1]])
    <h4>Start screen</h4>
    @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>5,'limit'=>1]])
    <h4>Help slides</h4>
    @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>6,'limit'=>10]])
    <h4>3D files</h4>
    @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>4,'limit'=>99]])
@stop

{{-- JS starts: javascript codes go here.--}}
@section('js')
    @parent
    <script type="text/javascript">
        @if(!isset($$element))
        /*******************************************************************/
        // Creating :
        // this is a place holder to write  the javascript codes
        // during creation of an element. As this stage $$element or $tenant(module
        // name singular) is not set, also there is no id is created
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();
        @elseif(isset($$element))
        /*******************************************************************/
        // Updating :
        // this is a place holder to write  the javascript codes that will run
        // while updating an element that has been already created.
        // during update the variable $$element or $tenant(module
        // name singular) is set, and id like other attributes of the element can be
        // accessed by calling $$element->id, also $tenant->id
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();
        @endif


        /*******************************************************************/
        // Saving :
        // Saving covers both creating and updating (Similar to Eloquent model event)
        // However, it is not guaranteed $$element is set. So the code here should
        // be functional for both case where an element is being created or already
        // created. This is a good place for writing validation
        // Following the convention of spyrframe you are only allowed to call functions
        /*******************************************************************/

        // your functions go here
        // function1();
        // function2();

        /*******************************************************************/
        // frontend and Ajax hybrid validation
        /*******************************************************************/
        addValidationRulesForSaving(); // Assign validation classes/rules
        enableValidation('{{$module_name}}'); // Instantiate validation function

        /*******************************************************************/
        // List of functions
        /*******************************************************************/

        // Assigns validation rules during saving (both creating and updating)
        function addValidationRulesForSaving() {
            $('input[name=name]').addClass('validate[required]');
        }
    </script>
@stop
{{-- JS ends --}}