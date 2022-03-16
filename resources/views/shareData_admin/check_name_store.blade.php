@extends('layouts.masterAdmin')

@section('content')
@php 
    $action_search = "admin/data_name_store/search";
    $path_detail = "admin/data_name_store/detail";
@endphp

@include('shareData_union.check_name_store')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
