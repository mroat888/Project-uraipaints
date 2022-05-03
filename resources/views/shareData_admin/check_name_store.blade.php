@extends('layouts.masterAdmin')

@section('content')

    @php 
        $action_search = "admin/data_name_store/search";
        $path_detail = "admin/data_name_store/detail";
        $position_province = "admin";
    @endphp

    @include('shareData_union.check_name_store')  

@endsection

@section('footer')
    @include('layouts.footer')
@endsection


