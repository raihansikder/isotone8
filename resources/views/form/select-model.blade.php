<?php
/**
 * @var array $var A temporary variable, that is set only to render the view partial. Usually this view
 *                 file is included inside a form.
 * @var $errors    \Illuminate\Support\MessageBag
 */

/** Common view parameters for form elements For details of the fields see app/views/spyr/form/input-text.blade.php */
$var['container_class'] = (isset($var['container_class'])) ? $var['container_class'] : '';
$var['name'] = (isset($var['name'])) ? $var['name'] : 'NO_NAME';
$var['params'] = (isset($var['params'])) ? $var['params'] : [];
$var['params']['class'] = (isset($var['params']['class'])) ? $var['params']['class'] . " form-control " : ' form-control ';
$var['value'] = (isset($var['value'])) ? $var['value'] : '';
$var['label'] = (isset($var['label'])) ? $var['label'] : '';
$var['label_class'] = (isset($var['label_class'])) ? $var['label_class'] : '';
$var['blank_select'] = (isset($var['blank_select'])) ? 'Select ' . lcfirst($var['blank_select']) : 'Select';
$var['old_input'] = oldInputValue($var['name'], $var['value']);
$var['cache_time'] = (isset($var['cache_time'])) ? $var['cache_time'] : 'none';
if (!isset($var['editable'])) {
    $var['editable'] = (isset($spyr_element_editable) && $spyr_element_editable == false) ? false : true;
}

/** Custom parameters */
$var['multiple'] = (array_search('multiple', $var['params']) !== false) ? true : false; // multiple: Store a flag if multiple selection is provided $var['params']

$var['table'] = (isset($var['table'])) ? $var['table'] : '';        // table: Name the database table (without prefix) from where options will be fetched.
$var['name_field'] = (isset($var['name_field'])) ? $var['name_field'] : 'name'; // name_field: Column of the table that will be shown as the readable name of the option for user. Usually this field is a text field. i.e. name, name_ext. Default is 'name'.
$var['value_field'] = (isset($var['value_field'])) ? $var['value_field'] : 'id'; // value_field: Column of the table that will be used for the value that will be actually posted. Usually this field is an id field. Default is 'id'.
$var['sql_extension'] = (isset($var['sql_extension'])) ? $var['sql_extension'] : ''; // sql_extension: Sometimes a filtered list of name-value is required to be presented as option. SQL additional filter clause can be added through this variable. (i.e. 'AND deleted_at IS NULL')

$query = DB::table(dbTable($var['table']))->select([$var['name_field'], $var['value_field']])
    ->whereNull('deleted_at')->where('is_active', 1);

if (userTenantId() && tableHasColumn($var['table'], tenantIdField())) {
    $query = $query->where(tenantIdField(), userTenantId());
}

$pairs = cachedResult($query, cacheTime('short'));

/** Prepare options */
$options = ['' => $var['blank_select']];
if (count($pairs)) {
    $v = $var['value_field'];
    $n = $var['name_field'];
    foreach ($pairs as $pair) {
        $options[$pair->$v] = $pair->$n;
    }
}
?>

{{-- HTML for the input/select block --}}
<div class="form-group {{$errors->first($var['name'], ' has-error')}} {{$var['container_class']}}">
    @if(strlen(trim($var['label'])))
        <label id="label_{{$var['name']}}" class="control-label {{$var['label_class']}}"
               for="{{$var['name']}}">{{$var['label']}}</label>
    @endif
    @if($var['editable'])
        <?php $var['select_name'] = ($var['multiple']) ? $var['name'] . "[]" : $var['name']; ?>
        {{ Form::select($var['select_name'], $options, $var['old_input'], $var['params']) }}
        {{ $errors->first($var['name'], '<span class="help-block">:message</span>') }}
    @else
        <span class="{{$var['params']['class']}} readonly">
            @if($var['multiple'])
                {{ tableColumnValsToCsv($var['table'],$var['name_field'], " AND id IN(".implode(',',$var['old_input']).")" ) }}
            @else
                <?php if (!isset($$element->$var['name'])) $$element->$var['name'] = -1; ?>
                {{ tableColumnValsToCsv($var['table'],$var['name_field'], " AND id =". $$element->$var['name'] ) }}
            @endif &nbsp;
        </span>
    @endif
</div>

{{-- Unset the local variable used in this view. --}}
<?php unset($var) ?>