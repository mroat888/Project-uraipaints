@extends('layouts.masterHead')

@section('content')

@php 
    $action_search = "headManage/data_report_sale_compare-year/search";
    $path_detail = "checkstore_campaigns/header/detail/";
    $position_province = "saleheaders";
@endphp  

@include('shareData_union.report_sale_compare_year')  


@endsection


@section('footer')
    @include('layouts.footer')
@endsection
