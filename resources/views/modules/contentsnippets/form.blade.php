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
{{--name--}}
@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-4']])
{{--code--}}
@include('form.input-text',['var'=>['name'=>'code','label'=>'Code', 'container_class'=>'col-sm-4']])
<div class="clearfix"></div>
{{--snippettype--}}
@include('form.select-array', ['var'=>['name'=>'snippettype','label'=>'Snippet Type','options'=>Contentsnippet::$snippettypes, 'container_class'=>'col-sm-4']])
{{--tenant_id--}}
@include("form.select-tenant")
<div class="clearfix"></div>

{{--html--}}
@include('form.textarea', ['var'=>['name'=>'html','label'=>'Content Snippet','container_class'=>'col-sm-8']])

<div class="clearfix"></div>

{{--plaintext--}}
@include('form.textarea', ['var'=>['name'=>'plaintext','label'=>'Alternative Plain Text']])

<?php $options = array(0 => 'No', 1 => 'Yes')?>
{{--is_default--}}
@include('form.select-array', ['var'=>['name'=>'is_default','label'=>'Is_default?','options'=>$options,'container_class'=>'col-sm-2' ]])
<div class="col-sm-8">
    <small>(If you mark as yes the snipped you save will be default for the creator(user). If the creator(user) already
        has a default snippet of the same snippet type then the current one will over ride)
    </small>
</div>


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
            $("textarea[name=html]").addClass('validate[required]');
            $("select[name=snippettype]").addClass('validate[required]');
        }

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
@endsection
{{-- JS ends --}}