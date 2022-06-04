@extends('layouts.masterAdmin')

@section('content')

@php 
    $action_search = "admin/data_report_full-year/search";
@endphp

@include('shareData_union.report_full_year')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

