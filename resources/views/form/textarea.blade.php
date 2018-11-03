<?php
/**
 * @var array $var A temporary variable, that is set only to render the view partial. Usually this view
 *                 file is included inside a form.
 * @var $errors \Illuminate\Support\MessageBag
 */

/** Common view parameters for form elements */
$var['container_class'] = (isset($var['container_class'])) ? $var['container_class'] : '';
$var['name'] = (isset($var['name'])) ? $var['name'] : 'NO_NAME';
$var['params'] = (isset($var['params'])) ? $var['params'] : [];
$var['params']['class'] = (isset($var['params']['class'])) ? $var['params']['class'] . " form-control " : ' form-control ';
$var['value'] = (isset($var['value'])) ? $var['value'] : '';
$var['label'] = (isset($var['label'])) ? $var['label'] : '';
$var['label_class'] = (isset($var['label_class'])) ? $var['label_class'] : '';
$var['old_input'] = oldInputValue($var['name'], $var['value']);
if (!isset($var['editable'])) {
    $var['editable'] = (isset($spyr_element_editable) && $spyr_element_editable == false) ? false : true;
}

/** Custom parameters */
$var['params']['id'] = (isset($var['params']['id'])) ? $var['params']['id'] : $var['name'];
?>
{{-- HTML for the input/select block --}}
<div class="form-group {{$errors->first($var['name'], ' has-error')}} {{$var['container_class']}}">
    @if(strlen(trim($var['label'])))
        <label id="label_{{$var['name']}}" class="control-label {{$var['label_class']}}" for="{{$var['name']}}">
            {{$var['label']}}
        </label>
    @endif
    @if($var['editable'])
        {{ Form::textarea($var['name'], $var['old_input'], $var['params']) }}
        {{ $errors->first($var['name'], '<span class="help-block">:message</span>') }}
    @else
        <span class="{{$var['params']['class']}} readonly">{{$$element->$var['name']}} &nbsp;</span>
    @endif
</div>

{{-- js --}}
@section('js')
    @parent
    {{-- Instantiate the ckeditor if the class 'ckeditor' is added in textarea--}}
    @if(strstr($var['params']['class'], 'ckeditor'))
        <script>
            initEditor('{{$var['params']['id']}}', editor_config_basic);
        </script>
    @endif
@stop

{{-- Unset the local variable used in this view. --}}
<?php unset($var) ?>