@extends('template.app-frame')
{{-- Master view file for report --}}


@section('head')
    @parent
    <style>
        .nav-tabs-custom > .tab-content {
            padding: 0;
        }
    </style>
@endsection

@section('title')
    @if(Request::has('submit') && hasPermission('reports.create'))
        <?php
        // $report_save_url = route('reports.create');
        $report_save_url = ''; // Todo : Temporary dummy. Need to
        //
        $report_save_url .= "?name=" . Request::get('report_name');
        $report_save_url .= "&code=" . Route::getCurrentRoute()->getParameter('code');
        $report_save_url .= "&is_public=No";
        $report_save_url .= "&is_reportviewer=Yes";
        //$report_save_url .= "&is_jasperreport=No";
        ?>
        @if(Request::has('type') && Request::get('type')=='Module Generic Report')
            <?php
            $generic_url = str_replace(route('home'), '', URL::full());
            $generic_url = str_replace("&type=Module%20Generic%20Report", '', $generic_url);
            $report_save_url .= "&type=Module Generic Report";
            $report_save_url .= "&parameter=" . urlencode($generic_url);
            ?>
            <a target="_blank" class="btn btn-default" href="{{$report_save_url}}"><i class="fa fa-save"></i>
                <small>Save this Report</small>
            </a>
        @else
            <?php
            $report_save_url .= "&parameter=" . urlencode($_SERVER['QUERY_STRING']);
            $report_save_url .= "&version=2.0";
            ?>
            <a target="_blank" class="btn btn-default" href="{{$report_save_url}}"><i class="fa fa-save"></i></a>
        @endif
    @endif
    @if (Request::has('report_name'))
        <h4>{{Request::get('report_name')}}</h4>
    @else
        <h4>{{Route::getCurrentRoute()->getParameter('code')}}</h4>
    @endif
@endsection



@section('js')
    @parent
    <script type="text/javascript">
        $('#right-side').addClass('stretch');
        $('#left-side').addClass('collapse-left');
    </script>
@endsection