<table id="{{$module_name}}Grid" class="table table-bordered table-striped module-grid" width="100%">
    <thead>
    <tr>
        {{-- print the headers/columns --}}
        @foreach($grid_columns as $c)
            <th>{{$c}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    <tr>
        {{-- print empty rows to match the number of headers/columns --}}
        @foreach($grid_columns as $c)
            <td></td>
        @endforeach
    </tr>
    </tbody>
</table>

{{-- js --}}
@section('js')
    @parent
    <script type="text/javascript">
        var table = $('.module-grid').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "{{ route($module_name . '.grid')}}?{{parse_url(URL::full(), PHP_URL_QUERY)}}",
            "aaSorting": [[0, "desc"]],
        }).fnSetFilteringDelay(3000);
    </script>
@stop