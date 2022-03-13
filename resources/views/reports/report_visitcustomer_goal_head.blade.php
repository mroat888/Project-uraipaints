@extends('layouts.masterHead')

@section('content')

@php 
    if(isset($sel_year)){
        $year = $sel_year;
    }else{
        $year = date('Y');
    }
    $action = '/headManage/report_visitcustomer_goal_head/search';
@endphp

@include('reports.report_visitcustomer_goal_union')

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

