@extends('layouts.masterHead')

@section('content')
       
    @php 
        $url_back = "head/approve_trip";
    @endphp

    @include('union.approval_trip_showdetail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
