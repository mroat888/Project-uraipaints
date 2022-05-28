@extends('layouts.masterLead')

@section('content')

    @php 
        $url_back = "lead/approval-customer-except-history";
    @endphp
    
    @include('union.customer_lead_detail')

@endsection('content')

@section('footer')
    @include('layouts.footer')
@endsection('footer')