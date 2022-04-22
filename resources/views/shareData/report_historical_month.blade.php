@extends('layouts.master')

@section('content')

@php 
    $action_search = "data_report_historical-month/search";
@endphp 

@include('shareData_union.report_historical_month')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

