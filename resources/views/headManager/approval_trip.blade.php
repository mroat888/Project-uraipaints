@extends('layouts.masterHead')

@section('content')
    
    @php 
        $url_approve_trip = "head/approve_trip";
        $action_search = "head/approve_trip/search";
        $url_approve_trip_history = "head/approve_trip/history";
        $url_showdetail = "head/approve_trip/detail";
    @endphp

    @include('union.approval_trip')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
