@extends('layouts.masterHead')

@section('content')

@php 
    $action_search = "headManage/data_report_historical-month/search";
@endphp 

@include('shareData_union.report_historical_month')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

