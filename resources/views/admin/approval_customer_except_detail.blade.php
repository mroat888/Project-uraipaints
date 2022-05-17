@extends('layouts.masterAdmin')

@section('content')

    @php 
        $url_back = "admin/change_customer_status";
    @endphp
    
    @include('union.customer_lead_detail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')