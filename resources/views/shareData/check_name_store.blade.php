@extends('layouts.master')

@section('content')

@php 
    $action_search = "data_name_store/search";
    $path_detail = "data_name_store/detail";
@endphp

@include('shareData_union.check_name_store')  


@section('footer')
    @include('layouts.footer')
@endsection


@endsection
