@extends('template.report')

@include('modules.shoporders.report.init-functions')

@section('content')
    {{-- ---------------------------------------\
    \ Include top filter box
    \------------------------------------------}}
    @include("modules.shoporders.report.filters")
    {{-- ---------------------------------------\
    \ Show search result if submit=run
    \------------------------------------------}}
    @if(Input::get('submit')=='Run' && isset($results))
        Total {{count($results)}} items found.
        <div class="clearfix"></div>
        @if(count($results))
            <table class="table table-condensed" id="report-table">
                <thead>
                <tr>
                    <th>S/L</th>
                    @foreach (arrayFromCsv(Input::get('column_aliases_csv')) as $column_alias)
                        <th>{{$column_alias}}</th>
                    @endforeach
                    {{-- if SQL 'GROUP' is set then post stats (male, female, filled etc) are shown--}}
                    @if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by'))))
                        <th>Total</th>
                    @endif
                    {{-- end stat headings --}}
                </tr>
                </thead>
                <tbody>
                <?php $i = $pagination->getFrom(); ?>
                @foreach ($results as $result)
                    <tr>
                        <td>{{$i++}}</td>
                        @foreach (arrayFromCsv(Input::get('columns_to_show_csv')) as $column)
                            <td>@if(isset($result->$column)){{transform($column,$result,$result->$column,$module_name)}}@endif</td>
                        @endforeach
                        {{-- if SQL 'GROUP' is set then post stats (male, female, filled etc) are shown --}}
                        @if (Input::has('group_by') && strlen(Input::get('group_by')))
                            <td>{{number_format($result->total)}}</td>
                        @endif
                        {{-- end stat ounts --}}
                    </tr>
                @endforeach
                <tr>

                     @if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by'))))
                        @foreach (arrayFromCsv(Input::get('columns_to_show_csv')) as $column)
                            <td></td>
                        @endforeach
                        {{-- if 'SQL GROUP is set then show additional row showing total counts in the last column '--}}
                        @if (Input::has('group_by') && strlen(cleanCsv(Input::get('group_by'))))
                                <td></td>
                                <td>Total : <b>{{number_format($total)}}</b></td>
                        @endif
                    @endif
                </tr>
                </tbody>
            </table>
            {{--{{ $paginator->links() }}--}}
            {{ $pagination->appends(Input::except('page'))->links() }}
        @endif

    @endif
@stop

@section('js')
    @parent
    @include('modules.shoporders.report.js')
    {{-- if you have any specific JS for this report write it here --}}
@stop