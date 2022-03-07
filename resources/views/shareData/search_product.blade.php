@extends('layouts.master')

@section('content')

@php
    $action_search = "data_search_product/search";
@endphp

@include('shareData_union.search_product')  

@section('footer')
    @include('layouts.footer')
@endsection



@endsection
