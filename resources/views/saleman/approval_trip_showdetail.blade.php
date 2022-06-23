@extends('layouts.master')

@section('content')
       
    @php 
        $url_back = "trip";
    @endphp

    @include('union.approval_trip_showdetail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
