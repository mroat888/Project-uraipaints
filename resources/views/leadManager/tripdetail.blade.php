@extends('layouts.masterLead')

@section('content')
       
    @php 
        $url_back = "lead/trip";
    @endphp

    @include('union.tripdetail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
