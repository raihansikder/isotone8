<?php
/**
 * @var $mod Module
 * @var $var array
 */
$rand = randomString();
/** View parameters */
$var['id'] = isset($var['id']) ? $var['id'] : null;
$var['limit'] = isset($var['limit']) ? $var['limit'] : 999;
$var['container_class'] = isset($var['container_class']) ? $var['container_class'] : ''; // container_class: main wrapper div class.
$var['upload_container_id'] = "img_container_" . $rand;
?>
{{-- upload div + form --}}
<div class="{{$var['container_class']}}">
    @if(hasModulePermission($mod->name,'create') || hasModulePermission($mod->name,'edit'))
        {{-- A form where values are stored that are later posted with attached file --}}
        {{-- initUploader gets these values and post to uplaod route  --}}
        <div id="{{$var['upload_container_id']}}" class="uploads_container">
            <form>
                <input type="hidden" name="ret" value="json"/>
                <input type="hidden" name="id" value="{{$var['id']}}"/>
            </form>
            <div id="fileuploader">Upload file</div>
        </div>
    @endif
</div>
{{-- js --}}
@section('js')
    @parent
    @if(hasModulePermission($mod->name,'create') || hasModulePermission($mod->name,'edit'))
        <script>
            initUploader("{{$var['upload_container_id']}}", "{{ route('uploads.update_last_upload')}}"); // init initially
        </script>
    @endif
@endsection
<?php unset($var); ?>


