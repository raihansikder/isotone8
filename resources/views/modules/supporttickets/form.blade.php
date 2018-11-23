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
@include('form.input-text',['var'=>['name'=>'name','label'=>'Subject', 'container_class'=>'col-sm-6']])
@include("form.select-tenant")
@include('form.select-model',['var'=>['name'=>'parent_id','label'=>'Concern Department/Person', 'table'=>'supportticketcategories', 'container_class'=>'col-sm-4']])
@if(isset($supportticket))
    @include('form.select-model',['var'=>['name'=>'supportticketcategory_id','label'=>'Select Sub Category', 'table'=>'supportticketcategories', 'container_class'=>'col-sm-4']])
@else
    <div class="form-group col-sm-4">
        <label for="title">Sub Category</label> <select name="supportticketcategory_id" class="form-control">
            <option value="">Select</option>
        </select>
    </div>
@endif


@include('form.input-text', ['var'=>['name'=>'contact_no','label'=>'Contact No.','container_class'=>'col-sm-4']])
@include('form.textarea', ['var'=>['name'=>'details','label'=>'Details(English/Bangla)','container_class'=>'col-sm-8']])
<div class="clearfix"></div>
@include('form.select-model',['var'=>['name'=>'supportticketstatus_id','label'=>'Ticket status', 'table'=>'supportticketstatuses', 'container_class'=>'col-sm-4']])
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
            $('input[name=contact_no]').addClass('validate[required,custom[number],maxSize[11],min[0]');
            $('textarea[name=details]').addClass('validate[required]');
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
        initEditor('details', editor_config_basic_custom);
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
        $(document).ready(function () {
            $('select[name=parent_id]').on('change', function () {
                var parent_id = $(this).val();
                console.log(parent_id);
                if (parent_id) {
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '<?= route('supportticketcategories.getJson'); ?>?parent_id=' + parent_id,
                        success: function (result) {
                            console.log(result.data.length);
                            if (result.data.length > 0) {
                                var option = '';
                                for (var i = 0; i < result.data.length; i++) {
                                    option += '<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>';
                                }
                                $('select[name=supportticketcategory_id]').html(option);
                            }
                            else {
                                $('select[name=supportticketcategory_id]').html('<option value="">No category found</option>');
                            }

                        }
                    });
                } else {
                    $('select[name=supportticketcategory_id]').html('<option value="">Select</option>');
                }
            });
        });
        enableValidation('{{$module_name}}'); // Instantiate validation function
    </script>
@endsection
{{-- JS ends --}}