@extends('layouts.master')

@section('content')

@php 
    $action_search = "data_report_sale_compare-year/search";
    $path_detail = "checkstore_campaigns/sellers/detail/";
    $position_province = "sellers";
@endphp  
@include('shareData_union.report_sale_compare_year')  

@section('footer')
    @include('layouts.footer')
@endsection

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>


@endsection


