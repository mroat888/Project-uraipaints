@extends('layouts.masterHead')
@section('content')

@php 
    if(isset($sel_year)){
        $year = $sel_year;
    }else{
        $year = date('Y');
    }
    $action = '/headManage/reportSaleplan/search';
@endphp

@include('reports.report_saleplan_union_v2');

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
