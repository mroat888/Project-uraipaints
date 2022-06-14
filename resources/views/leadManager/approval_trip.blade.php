@extends('layouts.masterLead')

@section('content')
    
    @php 
        $url_approve_trip = "lead/approve_trip";
        $url_approve_trip_history = "lead/approve_trip_history";
    @endphp

    @include('union.approval_trip')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
