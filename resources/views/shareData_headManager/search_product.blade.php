@extends('layouts.masterHead')

@section('content')

@php
    $action_search = "headManage/data_search_product/search";
@endphp

@include('shareData_union.search_product')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
