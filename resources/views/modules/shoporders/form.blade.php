<?php
/**
 * For documentation and global variables on how form.blade views please refer to
 * parent template \app\views\spyr\modules\groups\form.blade.php
 *
 * Variables used in this view file.
 * @var $module_name           string 'superheroes'
 * @var $mod                   Module
 * @var $superhero             Superhero Object that is being edited
 * @var $element               string 'superhero'
 * @var $spyr_element_editable boolean
 * @var $uuid                  string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 * @var $buyer                 User
 */

if (isset($shoporder->id)) {
    if (user()->isBuyer()) {
        // $spyr_element_editable = false;
    }
}

?>

{{-- Form starts: Form fields are placed here. These will be added inside the spyrframe default form container in
 app/views/spyr/modules/base/form.blade.php --}}
{{--@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])--}}
@include('form.input-hidden',['var'=>['name'=>'buyer_id','label'=>'Buyer Id', 'container_class'=>'col-sm-6']])
<div class="clearfix"></div>

{{-- Billing information --}}
<div class="panel panel-default" style="margin-bottom: 10px;">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse_billing_information">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Billing Information </a>
        </h4>
    </div>
    <div id="collapse_billing_information" class="panel-collapse collapse" style="padding: 20px; margin-bottom: 10px;">
        <div class="clearfix"></div>
        {{--first_name--}}
        @include('form.input-text',['var'=>['name'=>'first_name','label'=>'First name', 'container_class'=>'col-sm-6']])
        {{--last_name--}}
        @include('form.input-text',['var'=>['name'=>'last_name','label'=>'Last name', 'container_class'=>'col-sm-6']])
        {{--address1--}}
        @include('form.input-text',['var'=>['name'=>'address1','label'=>'Address 1', 'container_class'=>'col-sm-6']])
        {{--address2--}}
        @include('form.input-text',['var'=>['name'=>'address2','label'=>'Address 2', 'container_class'=>'col-sm-6']])
        {{--city--}}
        @include('form.input-text',['var'=>['name'=>'city','label'=>'City','container_class'=>'col-sm-6']])
        {{--county--}}
        @include('form.input-text',['var'=>['name'=>'county','label'=>'County', 'container_class'=>'col-sm-6']])
        {{--zip_code--}}
        @include('form.input-text',['var'=>['name'=>'zip_code','label'=>'ZIP code', 'container_class'=>'col-sm-6']])
        {{--country--}}
        @include('form.select-model',['var'=>['name'=>'country_id','label'=>'Country', 'table' =>'countries','container_class'=>'col-sm-6']])
        {{--phone--}}
        @include('form.input-text',['var'=>['name'=>'phone','label'=>'Phone', 'container_class'=>'col-sm-6']])
        <div class="clearfix"></div>
    </div>
</div>

{{-- Shipping information --}}
<div class="panel panel-default" style="margin-bottom: 10px;">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse_shipping_information">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Shipping Information </a>
        </h4>
    </div>
    <div id="collapse_shipping_information" class="panel-collapse collapse" style="padding: 20px; margin-bottom: 10px;">
        {{--same as billing--}}
        @include('form.input-checkbox', ['var'=>['name'=>'is_same_as_billing','label'=>'Same as billing','container_class'=>'col-sm-3 no-margin']])

        <div class="clearfix"></div>
        {{--shipping_first_name--}}
        @include('form.input-text',['var'=>['name'=>'shipping_first_name','label'=>'First name', 'container_class'=>'col-sm-6']])
        {{--shipping_last_name--}}
        @include('form.input-text',['var'=>['name'=>'shipping_last_name','label'=>'Last name', 'container_class'=>'col-sm-6']])
        {{--address1--}}
        @include('form.input-text',['var'=>['name'=>'shipping_address1','label'=>'Address 1', 'container_class'=>'col-sm-6']])
        {{--address2--}}
        @include('form.input-text',['var'=>['name'=>'shipping_address2','label'=>'Address 2', 'container_class'=>'col-sm-6']])
        {{--city--}}
        @include('form.input-text',['var'=>['name'=>'shipping_city','label'=>'City','container_class'=>'col-sm-6']])
        {{--county--}}
        @include('form.input-text',['var'=>['name'=>'shipping_county','label'=>'County', 'container_class'=>'col-sm-6']])
        {{--zip_code--}}
        @include('form.input-text',['var'=>['name'=>'shipping_zip_code','label'=>'ZIP code', 'container_class'=>'col-sm-6']])
        {{--country--}}
        @include('form.select-model',['var'=>['name'=>'shipping_country_id','label'=>'Country', 'table' =>'countries','container_class'=>'col-sm-6']])
        {{--phone--}}
        @include('form.input-text',['var'=>['name'=>'shipping_phone','label'=>'Phone', 'container_class'=>'col-sm-6']])
        <div class="clearfix"></div>
    </div>
</div>

{{-- Shipping method --}}
<div class="panel panel-default" style="margin-bottom: 10px;">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse_shipping_method">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Shipping Method </a>
        </h4>
    </div>
    <div id="collapse_shipping_method" class="panel-collapse collapse" style="padding: 20px; margin-bottom: 10px;">
        <div class="clearfix"></div>
        {{--shippingmethod_id--}}
        @include('form.select-model',['var'=>['name'=>'shippingmethod_id','label'=>'Select a shipping method', 'table' =>'shippingmethods','container_class'=>'col-sm-6']])
        <div class="clearfix"></div>
    </div>
</div>

{{-- Payment method --}}
<div class="panel panel-default" style="margin-bottom: 10px;">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse_payment_method">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Payment Method </a>
        </h4>
    </div>
    <div id="collapse_payment_method" class="panel-collapse collapse" style="padding: 20px; margin-bottom: 10px;">
        <div class="clearfix"></div>
        {{--shippingmethod_id--}}
        @include('form.select-model',['var'=>['name'=>'paymentmethod_id','label'=>'Select a payment method', 'table' =>'paymentmethods','container_class'=>'col-sm-6']])
        <div class="clearfix"></div>
    </div>
</div>

{{-- Order review --}}
<div class="panel panel-default" style="margin-bottom: 10px;">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse_order_review">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                Order review </a>
        </h4>
    </div>
    <div id="collapse_order_review" class="panel-collapse collapse" style="padding: 20px; margin-bottom: 10px;">
        <div class="clearfix"></div>
        <?php
        if (!isset($shoporder)) $cartitems = Shop::cartitems();
        else $cartitems = $shoporder->cartitems;
        ?>

        @include('shop.cart.cart-table',['var'=>['cartitems'=>$cartitems, 'deletable'=>false]])
        <div class="clearfix"></div>
    </div>
</div>
@section('content-bottom')
    @parent
    @if(isset($shoporder->id))
        <div class="col-md-6 no-padding-l">
            <h4>Payment</h4>
            @include('modules.shoporders.payment')
        </div>

        <div class="col-md-6 no-padding-l">
            <h4>Messages</h4>
            <h6>If you have any query or want to add additional note please write to us.</h6>
            @include('modules.base.messages')
        </div>
    @endif
@endsection
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
            $('input[name=first_name]').addClass('validate[required,maxSize[100]]');
            $('input[name=last_name]').addClass('validate[required,maxSize[100]]');
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
        copyBillingAddress();//copy billing address to shipping address
    </script>
@endsection
{{-- JS ends --}}