@extends('layouts.masterAdmin')

@section('content')

@php 
    $action_search = "admin/data_report_historical-quarter/search";
@endphp 

@include('shareData_union.report_historical_quarter')  

@section('footer')
    @include('layouts.footer')
@endsection

 <!-- EChartJS JavaScript -->
 <script src="{{asset('public/template/vendors/echarts/dist/echarts-en.min.js')}}"></script>
 <script src="{{asset('public/template/barcharts/barcharts-data.js')}}"></script>
 
@endsection

