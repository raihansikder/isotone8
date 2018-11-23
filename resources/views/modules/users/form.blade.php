<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'users'
 * @var $mod                   Module
 * @var $user                  User Object that is being edited
 * @var $element               string 'user'
 * @var $spyr_element_editable boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>

{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
@include('form.input-text',['var'=>['name'=>'name','label'=>'User name(login name)', 'container_class'=>'col-sm-3']])
@include('form.input-text',['var'=>['name'=>'email','label'=>'Email', 'container_class'=>'col-sm-3']])

{{-- show password only for editable--}}
@if($spyr_element_editable)
    <div class="clearfix"></div>
    @include('form.input-text',['var'=>['name'=>'password','type'=>'password','label'=>'Password', 'container_class'=>'col-sm-3','value'=>'']])
    @include('form.input-text',['var'=>['name'=>'password_confirm','type'=>'password','label'=>'Confirm password', 'container_class'=>'col-sm-3']])
@endif

<div class="clearfix"></div>


@if(user()->isSuperUser())
    <?php
    $group_ids = (isset($user)) ? $user->groupIds() : [];
    $sql_extension = (tenantUser()) ? " AND name !='superuser'" : '';
    ?>
    @include('form.select-model',['var'=>['name'=>'group_ids','label'=>'Group','value'=>$group_ids, 'table'=>'groups', 'sql_extension' => $sql_extension, 'name_field'=>'title', 'container_class'=>'col-sm-3','params'=>['multiple','id'=>'groups']]])


    <div class="clearfix"></div>
    <div id="tenant">
        @include("form.select-tenant")
    </div>


    <div class="clearfix"></div>
    @include('form.select-array',['var'=>['name'=>'activated','label'=>'Active', 'options'=>['1'=>'Yes',''=>'No'],'container_class'=>'col-sm-3']])

    @if(user() && user()->isSuperUser())
        @include('form.select-array',['var'=>['name'=>'is_editable_by_tenant','label'=>'Is editable?', 'options'=>[0=>'No',1=>'Yes'],'container_class'=>'col-sm-3']])
    @endif

    <div class="col-md-12">
        @if(isset($user) && $user->api_token != null)
            <b>Current API token :</b> <code class="">{{$user->api_token}}</code>
        @endif
        <div class="control-group">
            <div class="controls">
                <div class="form-group">
                    <input class="pull-left" type="checkbox" name="api_token_generate" id="api_token_generate"
                           value="yes"/>
                    <b>Generate new API token</b>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- uploadtype_id = 7 Profile picture --}}
@if(isset($$element))
    <div class="clearfix"></div>
    <h4>Profile picture</h4>
    <?php $img_src = (count($$element->uploadProfilePic)) ? asset($$element->uploadProfilePic->path) : null; ?>
    @include('repository.addons.cropper.cropper',['var'=>['uploadtype_id'=>7,'img_src'=>$img_src]])
@endif
{{-- Form ends --}}

{{-- JS starts: javascript codes go here.--}}
@section('js')
    @parent
    <script type="text/javascript">
        @if(!isset($$element))
        /*******************************************************************/
        // Creating :
        // this is a place holder to write  the javascript codes
        // during creation of an element. As this stage $$element or $user(module
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
        // during update the variable $$element or $user(module
        // name singular) is set, and id like other attributes of the element can be
        // accessed by calling $$element->id, also $user->id
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
        $('form[name={{$module_name}}] input[name=redirect_success]').val('');

         hideSeller();

        $('select#groups').change(function () {
            hideSeller()
        });
        function hideSeller(){
            $('#tenant').hide();
            var group_id = $('select#groups').val();
            if(group_id == 2) $('#tenant').show();
        }


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
@endsection
{{-- JS ends --}}