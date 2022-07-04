@extends('layouts.masterLead')

@section('content')
    
    @php 
        $url_approve_trip = "lead/approve_trip";
        $action_search = "lead/approve_trip/search";
        $text_header = "อนุมัติทริปเดินทาง";
        $text_sub_header = "รายการรออนุมัติ";
        $text_sub_header_history = "ประวัติการอนุมัติ";
        $url_approve_trip_history = "lead/approve_trip/history";
        $url_showdetail = "lead/approve_trip/detail";
    @endphp

    @include('union.approval_trip')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
