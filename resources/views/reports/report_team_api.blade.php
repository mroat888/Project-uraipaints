@extends('layouts.masterLead')

@section('content')

@php 
    $position = "leader";
    $path_detail = "sellerdetail/".$position;
@endphp

@include('reports.report_team_api_union')

@section('footer')
    @include('layouts.footer')
@endsection


@endsection

