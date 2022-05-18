@extends('layouts.masterHead')

@section('content')

@php 
    $position = "header";
    $path_detail = "sellerdetail/".$position;
@endphp

@include('reports.report_team_api_union')

@section('footer')
    @include('layouts.footer')
@endsection

@endsection

