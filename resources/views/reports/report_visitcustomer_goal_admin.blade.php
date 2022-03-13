@extends('layouts.masterAdmin')

@section('content')

@php 
    if(isset($sel_year)){
        $year = $sel_year;
    }else{
        $year = date('Y');
    }
    $action = '/admin/report_visitcustomer_goal/search';
@endphp

@include('reports.report_visitcustomer_goal_union')

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

