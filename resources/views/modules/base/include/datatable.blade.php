<table id="{{$module_name}}Grid" class="table module-grid" width="100%">
    <thead>
    <tr>
        {{-- print the headers/columns --}}
        @foreach($grid_columns as $c)
            <th>{{$c[2]}}</th>
        @endforeach
    </tr>
    </thead>
</table>

{{-- js --}}
@section('js')
    @parent
    <script type="text/javascript">
        var table = $('.module-grid').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route($module_name . '.grid')}}?{{parse_url(URL::full(), PHP_URL_QUERY)}}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name'},
                { data: 'user_name', name: 'updater.name' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'is_active', name: 'updated_at' }
            ],
            "order": [[ 0, 'asc' ]]
        }).fnSetFilteringDelay(3000);
    </script>
@endsection