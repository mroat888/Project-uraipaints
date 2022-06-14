@extends('layouts.master')

@section('content')
       
    @php 
        $url_back = "trip";
    @endphp

    @include('union.tripdetail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
