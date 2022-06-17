@extends('layouts.masterLead')

@section('content')
    
    @php 
        $url_approve_trip = "lead/approve_trip";
        $action_search = "lead/approve_trip/history/search";
        $url_approve_trip_history = "lead/approve_trip/history";
        $url_trip_history_detail = "lead/approve_trip/detail";
    @endphp

    @include('union.approval_trip_history')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
