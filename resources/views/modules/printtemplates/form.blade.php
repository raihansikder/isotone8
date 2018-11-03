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
@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])
{{--code--}}
@include('form.input-text',['var'=>['name'=>'code','label'=>'Code', 'container_class'=>'col-sm-6']])
{{--printversiontype_id--}}
@include('form.select-model', ['var'=>['name'=>'printversiontype_id','label'=>'Type of Template','table'=>'printversiontypes','container_class'=>'col-sm-6']])

{{--tenant_id--}}
@include("form.select-tenant")
{{--module_id--}}
@include('form.select-model', ['var'=>['name'=>'module_id','label'=>'Module','table'=>'modules','container_class'=>'col-sm-6']])

{{--details--}}
@include('form.input-text',['var'=>['name'=>'details','label'=>'Description', 'container_class'=>'col-sm-12']])

{{--html--}}
@include('form.textarea',['var'=>['name'=>'html','label'=>'Template', 'container_class'=>'col-sm-8']])

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
            $("select[name=module_id]").addClass('validate[required]');
            $("select[name=printversiontype_id]").addClass('validate[required]');
            $("textarea[name=html]").addClass('validate[required]');
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
        initEditor('html', editor_config_basic_custom);
        var editor_config_basic_custom = {
            toolbarGroups: [
                {"name": "basicstyles", "groups": ["basicstyles"]},
                {"name": "links", "groups": ["links"]},
                {"name": "paragraph", "groups": ["list", "blocks"]},
                {"name": "document", "groups": ["mode"]},
                {"name": "insert", "groups": ["insert"]},
                {"name": "styles", "groups": ["styles"]},
                {"name": "about", "groups": ["about"]}
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar',
            // width
            width: 730,
            // extra plugins
            extraPlugins: 'autogrow',
            autoGrow_onStartup: true,
            //autoGrow_minHeight: 250,
            //autoGrow_maxHeight: 600
            autoParagraph: false // stop from automatically adding <p></p> tag
        };
        enableValidation('{{$module_name}}'); // Instantiate validation function
    </script>
@stop
{{-- JS ends --}}