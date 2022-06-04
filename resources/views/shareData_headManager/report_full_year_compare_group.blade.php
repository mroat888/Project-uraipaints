@extends('layouts.masterHead')

@section('content')

    @php 
        $url_report_total = "headManage/data_report_full-year";
        $url_report_group = "headManage/data_report_full-year_compare_group";
        
        $action_search = "headManage/data_report_full-year_compare_group/search";
    @endphp

    @include('shareData_union.report_full_year_compare_group')

@endsection


@section('footer')
    @include('layouts.footer')
@endsection
