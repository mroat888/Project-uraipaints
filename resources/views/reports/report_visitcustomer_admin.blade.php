@extends('layouts.masterAdmin')

@section('content')

@php 
    if(isset($sel_year)){
        $year = $sel_year;
    }else{
        $year = date('Y');
    }
    $action = '/admin/reportVisitCustomer/search';
@endphp

@include('reports.report_visitcustomer_union')

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

