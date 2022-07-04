@extends('layouts.masterHead')

@section('content')
    
    @php 
        $url_trip_detail = "head/trip/detail";
        $url_request = "manager/trip/request";
        $action_search= "head/trip/search";
    @endphp

    @include('union.trip')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
