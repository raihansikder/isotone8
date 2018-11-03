@extends('template.app-frame')

@section('sidebar-left')
    @include('modules.base.include.sidebar-left')
@stop

@section('title')
    @if(isset($title)){{$title}}@endif
@stop

@section('content')
    @if(isset($body)){{$body}}@endif
@stop

