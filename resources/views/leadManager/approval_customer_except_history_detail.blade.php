@extends('layouts.masterLead')

@section('content')

    @php 
        $url_back = "head/approval-customer-except";
    @endphp
    
    @include('union.customer_lead_detail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')