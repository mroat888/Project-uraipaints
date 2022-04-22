@extends('layouts.masterLead')

@section('content')

@php 
    $action_search = "leadManage/data_report_historical-year/search";
@endphp 

@include('shareData_union.report_historical_year')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

