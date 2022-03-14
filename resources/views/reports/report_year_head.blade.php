@extends('layouts.masterHead')

@section('content')

@php 
    if(isset($sel_year)){
        $year = $sel_year;
    }else{
        $year = date('Y');
    }
    $action = '/headManage/reportYear/search';

@endphp

@include('reports.report_year_union')

@section('footer')
    @include('layouts.footer')
@endsection


@endsection

