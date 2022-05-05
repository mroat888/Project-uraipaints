@extends('layouts.master')

@section('content')

    @php 
        $url_back = "lead";
    @endphp
    
    @include('union.customer_lead_detail');

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')


