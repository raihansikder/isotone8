@extends('template.app-frame')

<?php
/**
 * Variables used in this view file.
 * @var $module_name string 'superheroes'
 * @var $mod         Module
 * @var $uuid        string '1709c091-8114-4ba4-8fd8-91f0ba0b63e8'
 */
?>

@section('sidebar-left')
    @include('modules.base.include.sidebar-left')
@stop

@section('title')
    {{$mod->title}}
    {{--@if(hasModulePermission($module_name,"create"))--}}
        {{--<a class="btn btn-xs btn-default" href="{{route("$module_name.create")}}" data-toggle="tooltip"--}}
           {{--title="Create a new {{lcfirst(str_singular($mod->title))}}"><i class="fa fa-plus"></i> New</a>--}}
    {{--@endif--}}
    {{--<a class="btn btn-xs" href="{{route($module_name . '.report')}}?submit=Run&type=Module%20Generic%20Report&fields_csv=id%2Cname%2Ccreated_by%2Ccreated_at%2Cupdated_by%2Cupdated_at%2Cis_active&columns_to_show_csv=id%2Cname%2Ccreated_by%2Ccreated_at%2Cupdated_by%2Cupdated_at%2Cis_active&column_aliases_csv=Id%2CName%2CCreated+by%2CCreated+at%2CUpdated+by%2CUpdated+at%2CActive%3F&rows_per_page=100">View--}}
        {{--report</a>--}}
@stop

@section('content')
    @include('modules.base.include.datatable')
@stop
