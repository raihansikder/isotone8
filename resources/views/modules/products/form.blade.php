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
<div class="clearfix"></div>

@include('form.input-text',['var'=>['name'=>'name','label'=>'Name', 'container_class'=>'col-sm-6']])
@include('form.input-text',['var'=>['name'=>'code','label'=>'Code/SKU', 'container_class'=>'col-sm-2']])
@include('form.input-text',['var'=>['name'=>'price','label'=>'Price', 'container_class'=>'col-sm-2']])
@include('form.input-text',['var'=>['name'=>'order','label'=>'Order/Serial', 'container_class'=>'col-sm-2']])
<div class="clearfix"></div>

{{--@include('form.select-model',['var'=>['name'=>'prodcategory_id','label'=>'Category', 'table'=>'prodcategories', 'container_class'=>'col-sm-3']])--}}
{{--@include('form.select-array',['var'=>['name'=>'placement','label'=>'Placement type', 'options'=>['Floor'=>'Floor','Wall'=>'Wall'],'container_class'=>'col-sm-3']])--}}
@include('form.select-model',['var'=>['name'=>'paintingmedia_id','label'=>'Painting media', 'table'=>'paintingmedias', 'container_class'=>'col-sm-3','cache_time'=>'long']])
@include('form.select-model',['var'=>['name'=>'paintingstyle_id','label'=>'Style', 'table'=>'paintingstyles', 'container_class'=>'col-sm-3','cache_time'=>'long']])
@include('form.select-model',['var'=>['name'=>'paintingtype_id','label'=>'Painting type', 'table'=>'paintingtypes', 'container_class'=>'col-sm-2','cache_time'=>'long']])
@include('form.input-text',['var'=>['name'=>'height','label'=>'Height(cm)', 'container_class'=>'col-sm-2']])
@include('form.input-text',['var'=>['name'=>'width','label'=>'Width(cm)', 'container_class'=>'col-sm-2']])
<div class="clearfix"></div>

{{--@include('form.input-text',['var'=>['name'=>'rating','label'=>'Rating(1-5)', 'container_class'=>'col-sm-2']])--}}

@include('form.textarea',['var'=>['name'=>'desc','label'=>'Description', 'container_class'=>'col-sm-12']])
@include('form.input-text',['var'=>['name'=>'art_date','label'=>'Art date', 'container_class'=>'col-sm-4']])
@include('form.input-text',['var'=>['name'=>'stock_count','label'=>'Stock', 'container_class'=>'col-sm-2']])
<div class="clearfix"></div>
@include('form.textarea',['var'=>['name'=>'reviews','label'=>'Reviews', 'container_class'=>'col-sm-6']])
@include('form.textarea',['var'=>['name'=>'terms_and_conditions','label'=>'Terms & conditions', 'container_class'=>'col-sm-6']])
{{--@include('form.input-text',['var'=>['name'=>'buy_now_url','label'=>'Buy Now URL', 'container_class'=>'col-sm-12']])--}}
{{--@include('form.input-text',['var'=>['name'=>'color_variants','label'=>'Color variants(Input comma separated values)', 'container_class'=>'col-sm-6']])--}}
@include('form.is_active')
{{-- Form ends --}}

@section('content-bottom')
    @parent
    <div class="col-md-6 no-padding-l">
        <h4>Product thumbnail</h4>
        <small>Recommended size 500x500, square, PNG with transparent background</small>
        @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>3,'limit'=>5]])

        <h4>Product high-resolution images</h4>
        <small>Recommended size 1200x1200, square, PNG with transparent background</small>
        @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>8,'limit'=>5]])

    </div>

    <div class="col-md-6 no-padding-l">
        <h4>3D files - iOS</h4>
        <small>Upload 3D .lvr files</small>
        @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>4,'limit'=>5]])

        <h4>3D files - Android</h4>
        <small>Upload 3D .lvr files</small>
        @include('modules.base.include.uploads',['var'=>['uploadtype_id'=>10,'limit'=>5]])
    </div>
    {{--messages--}}
    {{--<div class="col-md-6 no-padding-l">--}}
        {{--@include('modules.base.messages')--}}
    {{--</div>--}}
@stop

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
            $('input[name=art_date]').addClass('validate[custom[date],past[now]] datepicker');
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
        $('input[name=art_date]').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            clearBtn: true
        });
        addValidationRulesForSaving(); // Assign validation classes/rules
        enableValidation('{{$module_name}}'); // Instantiate validation function

    </script>
@stop
{{-- JS ends --}}