@extends('layouts.masterAdmin')

@section('content')

@php 
    $action_search = "admin/data_report_sale_compare-year/search";
    $path_detail = "checkstore_campaigns/admin/detail/";
    $position_province = "admin";
@endphp  

@include('shareData_union.report_sale_compare_year')  


@endsection

@section('footer')
    @include('layouts.footer')
@endsection
