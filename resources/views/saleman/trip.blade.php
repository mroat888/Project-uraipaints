@extends('layouts.master');

@section('content')
    
    @php 
        $url_trip_detail = "trip/detail";
        $url_request = "trip/request";
        $action_search= "trip/search";
    @endphp

    @include('union.trip')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
