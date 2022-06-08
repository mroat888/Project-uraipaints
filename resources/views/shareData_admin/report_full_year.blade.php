@extends('layouts.masterAdmin')

@section('content')

    @php 
        $url_report_total = "admin/data_report_full-year";
        $url_report_group = "admin/data_report_full-year_compare_group";
        
        $action_search = "admin/data_report_full-year/search";
        $path_detail = "admin/data_report_full-year/detail";

        $disable_jquery = "disable"; //-- ใช้สำหรับ กำหนด script ในส่วน layout master 
        
    @endphp

    @include('shareData_union.report_full_year')

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
