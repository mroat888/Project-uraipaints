@extends('layouts.master')

@section('content')

    @php 
        $action_search = "data_report_customer_compare-year/search";
        $position_province = "sellers";
    @endphp  

    @include('shareData_union.report_customer_compare_year')  

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
