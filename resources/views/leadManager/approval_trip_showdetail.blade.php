@extends('layouts.masterLead')

@section('content')
       
    @php 
        $url_back = "lead/approve_trip";
    @endphp

    @include('union.approval_trip_showdetail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
