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

{{--Billing address--}}
<div class="col-md-6 no-padding">
    <h4>Billing address</h4>
    {{--first_name--}}
    @include('form.input-text',['var'=>['name'=>'first_name','label'=>'First name', 'container_class'=>'col-sm-6']])
    {{--last_name--}}
    @include('form.input-text',['var'=>['name'=>'last_name','label'=>'Last name', 'container_class'=>'col-sm-6']])
    {{--address1--}}
    @include('form.input-text',['var'=>['name'=>'address1','label'=>'Address 1', 'container_class'=>'col-sm-12']])
    {{--address2--}}
    @include('form.input-text',['var'=>['name'=>'address2','label'=>'Address 2', 'container_class'=>'col-sm-12']])
    {{--city--}}
    @include('form.input-text',['var'=>['name'=>'city','label'=>'City','container_class'=>'col-sm-12']])
    {{--county--}}
    @include('form.input-text',['var'=>['name'=>'county','label'=>'County', 'container_class'=>'col-sm-12']])
    {{--zip_code--}}
    @include('form.input-text',['var'=>['name'=>'zip_code','label'=>'ZIP code', 'container_class'=>'col-sm-12']])
    {{--country--}}
    @include('form.select-model',['var'=>['name'=>'country_id','label'=>'Country', 'table' =>'countries','container_class'=>'col-sm-12']])
    {{--phone--}}
    @include('form.input-text',['var'=>['name'=>'phone','label'=>'Phone', 'container_class'=>'col-sm-12']])
</div>

{{--Shipping address--}}
<div class="col-md-6 no-padding">
    <div class="col-md-9 no-padding">
        <h4>Shipping address</h4>
    </div>

    @include('form.input-checkbox', ['var'=>['name'=>'is_same_as_billing','label'=>'Same as billing','container_class'=>'col-sm-3 no-margin']])

    {{--shipping_first_name--}}
    @include('form.input-text',['var'=>['name'=>'shipping_first_name','label'=>'First name', 'container_class'=>'col-sm-6']])
    {{--shipping_last_name--}}
    @include('form.input-text',['var'=>['name'=>'shipping_last_name','label'=>'Last name', 'container_class'=>'col-sm-6']])
    {{--shipping_address1--}}
    @include('form.input-text',['var'=>['name'=>'shipping_address1','label'=>'Address 1', 'container_class'=>'col-sm-12']])
    {{--shipping_address2--}}
    @include('form.input-text',['var'=>['name'=>'shipping_address2','label'=>'Address 2', 'container_class'=>'col-sm-12']])
    {{--shipping_city--}}
    @include('form.input-text',['var'=>['name'=>'shipping_city','label'=>'City', 'container_class'=>'col-sm-12']])
    {{--shipping_county--}}
    @include('form.input-text',['var'=>['name'=>'shipping_county','label'=>'County', 'container_class'=>'col-sm-12']])
    {{--shipping_zip_code--}}
    @include('form.input-text',['var'=>['name'=>'shipping_zip_code','label'=>'ZIP code', 'container_class'=>'col-sm-12']])
    {{--shipping_country--}}
    @include('form.select-model',['var'=>['name'=>'shipping_country_id','label'=>'Country','table'=>'countries', 'container_class'=>'col-sm-12']])
    {{--shipping_phone--}}
    @include('form.input-text',['var'=>['name'=>'shipping_phone','label'=>'Phone', 'container_class'=>'col-sm-12']])
</div>

<div class="col-md-12 no-padding">
    <div class="col-md-9 no-padding">
        <h4>Other details</h4>
    </div>
    @include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])
    <div class="clearfix"></div>

    {{--about_me--}}
    @include('form.textarea',['var'=>['name'=>'about_me','label'=>'About me', 'container_class'=>'col-sm-6']])
    {{--specialisms_csv--}}
    @include('form.textarea',['var'=>['name'=>'specialisms_csv','label'=>'Specialism', 'container_class'=>'col-sm-6']])
    {{--interests_csv--}}
    @include('form.textarea',['var'=>['name'=>'interests_csv','label'=>'Interests', 'container_class'=>'col-sm-6']])
</div>
<div class="clearfix"></div>

{{--@include('form.is_active')--}}
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
            $('input[name=first_name]').addClass('validate[required,maxSize[100]]');
            $('input[name=last_name]').addClass('validate[required,maxSize[100]]');
            $('textarea[name=about_me]').addClass('validate[maxSize[1024]]');
            $('textarea[name=specialisms_csv]').addClass('validate[maxSize[512]]');
            $('textarea[name=interests_csv]').addClass('validate[maxSize[512]]');
            $('input[name=address1]').addClass('validate[required,maxSize[512]]');
            $('input[name=address2]').addClass('validate[required,maxSize[512]]');
            $('input[name=city]').addClass('validate[required,maxSize[50]]');
            $('input[name=county]').addClass('validate[required,maxSize[50]]');
            $('input[name=zip_code]').addClass('validate[required,maxSize[10]]');
            $('input[name=phone]').addClass('validate[required,custom[integer],min[0]]');
            $('input[name=shipping_first_name]').addClass('validate[required,maxSize[100]]');
            $('input[name=shipping_last_name]').addClass('validate[required,maxSize[100]]');
            $('input[name=shipping_address1]').addClass('validate[required,maxSize[512]]');
            $('input[name=shipping_address2]').addClass('validate[required,maxSize[512]]');
            $('input[name=shipping_city]').addClass('validate[required,maxSize[50]]');
            $('input[name=shipping_county]').addClass('validate[required,maxSize[50]]');
            $('input[name=shipping_zip_code]').addClass('validate[required,maxSize[10]]');
            $('input[name=shipping_phone]').addClass('validate[required,custom[integer],min[0]]');
        }

        //after checking the checkbox same as billing copy the billing address into shipping address
        function copyBillingAddress() {
            $("input[name=checkbox_is_same_as_billing]").on("click", function () {
                var ship = $(this).is(":checked");
                $("input[name^='shipping_']").each(function (e) {
                    var tmpName = this.name.split('shipping_')[1];
                    $(this).val(ship ? $("input[name=" + tmpName).val() : "");
                });
                $("select[name=shipping_country_id]").val(ship ? $("select[name=country_id]").val() : "").change();
            });
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
        copyBillingAddress() //copy billing address to shipping address
    </script>
@stop
{{-- JS ends --}}