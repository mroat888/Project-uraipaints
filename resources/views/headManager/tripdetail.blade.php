@extends('layouts.masterHead')

@section('content')
       
    @php 
        $url_back = "head/trip";
    @endphp

    @include('union.tripdetail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')
