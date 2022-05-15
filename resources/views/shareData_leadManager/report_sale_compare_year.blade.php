@extends('layouts.masterLead')

@section('content')

@php 
    $action_search = "leadManage/data_report_sale_compare-year/search";
    $path_detail = "checkstore_campaigns/leader/detail/";
    $position_province = "saleleaders";
@endphp  

@include('shareData_union.report_sale_compare_year')  

@section('footer')
    @include('layouts.footer')
@endsection


@endsection


