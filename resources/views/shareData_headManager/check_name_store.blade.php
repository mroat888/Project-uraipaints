@extends('layouts.masterHead')

@section('content')

@php 
    $action_search = "headManage/data_name_store/search";
    $path_detail = "headManage/data_name_store/detail";
    $position_province = "saleheaders";
@endphp

@include('shareData_union.check_name_store')  

@section('footer')
    @include('layouts.footer')
@endsection


@endsection
