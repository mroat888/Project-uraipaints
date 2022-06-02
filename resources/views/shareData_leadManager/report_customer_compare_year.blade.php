@extends('layouts.masterAdmin')

@section('content')

    @php 
        $action_search = "leadManage/data_report_customer_compare-year/search";
        $position_province = "saleleaders";
    @endphp  

    @include('shareData_union.report_customer_compare_year')  

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
