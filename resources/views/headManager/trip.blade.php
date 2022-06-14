@extends('layouts.masterHead')

@section('content')
    
    @php 
        $url_trip_detail = "head/trip/detail";
        $url_request = "manager/trip/request";
    @endphp

    @include('union.trip')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
