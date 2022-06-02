@extends('layouts.masterAdmin')

@section('content')

    @php 
        $action_search = "admin/data_report_customer_compare-year/search";
        $position_province = "admin";
    @endphp  

    @include('shareData_union.report_customer_compare_year')  

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
