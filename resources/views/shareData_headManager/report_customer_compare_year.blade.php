@extends('layouts.masterHead')

@section('content')

    @php 
        $action_search = "headManage/data_report_customer_compare-year/search";
        $position_province = "saleheaders";
    @endphp  

    @include('shareData_union.report_customer_compare_year')  

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
