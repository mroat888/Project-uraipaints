@extends('layouts.master')

@section('content')
    @php
        $url_report_total = "data_report_full-year";
        $url_report_group = "data_report_full-year_compare_group";

        $action_search = "data_report_full-year/search";
        $path_detail = "data_report_full-year/detail";
    @endphp

    @include('shareData_union.report_full_year')

@endsection

@section('footer')
    @include('layouts.footer')
@endsection



