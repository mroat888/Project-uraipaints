@extends('layouts.masterAdmin')

@section('content')

@php
    $title_header = "ประวัติอนุมัติคำขออนุมัติ";
    $title_header_table = "รายการประวัติขออนุมัติ";

    $action_search = "admin/approvalgeneral/history/search"; //-- action form
@endphp


<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $title_header }}</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

<!-- Container -->
<div class="container-fluid px-xxl-65 px-xl-20">
    <!-- Title -->
    <div class="hk-pg-header mb-10">
        <div class="topichead-bgred"><i data-feather="file-text"></i> {{ $title_header }}</div>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                @include('union.approval_general_history_table')
            </section>
        </div>
    </div>
    <!-- /Row -->
</div>
<!-- /Container -->

@endsection('content')
