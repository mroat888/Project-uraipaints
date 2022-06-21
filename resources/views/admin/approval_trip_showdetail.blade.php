@extends('layouts.masterAdmin')

@section('content')
       
    @php 
        $url_back = "admin/approve_trip";
    @endphp

    @include('union.approval_trip_showdetail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
