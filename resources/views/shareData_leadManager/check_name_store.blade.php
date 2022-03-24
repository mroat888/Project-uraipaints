@extends('layouts.masterLead')

@section('content')

@php 
    $action_search = "leadManage/data_name_store/search";
    $path_detail = "leadManage/data_name_store/detail";
    $position_province = "saleleaders";
@endphp

@include('shareData_union.check_name_store')  

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
