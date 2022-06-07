@extends('layouts.masterHead')

@section('content')

    @php 
        $action_search = "headManage/data_report_historical-year/search";
    @endphp 

    @include('shareData_union.report_historical_year') 

@endsection

@section('footer')
    @include('layouts.footer')
@endsection
