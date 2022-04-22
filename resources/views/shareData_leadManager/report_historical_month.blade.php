@extends('layouts.masterLead')

@section('content')

@php 
    $action_search = "leadManage/data_report_historical-month/search";
@endphp 

@include('shareData_union.report_historical_month')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

