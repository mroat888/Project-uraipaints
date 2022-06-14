@extends('layouts.masterLead')

@section('content')
    
    @php 
        $url_trip_detail = "lead/trip/detail";
        $url_request = "manager/trip/request";
    @endphp

    @include('union.trip')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
