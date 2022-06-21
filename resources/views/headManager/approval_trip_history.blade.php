@extends('layouts.masterHead')

@section('content')
    
    @php 
        $url_approve_trip = "head/approve_trip";
        $action_search = "head/approve_trip/history/search";
        $url_approve_trip_history = "head/approve_trip/history";
        $url_trip_history_detail = "head/approve_trip/detail";
    @endphp

    @include('union.approval_trip_history')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
