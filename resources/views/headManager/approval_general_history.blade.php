@extends('layouts.masterHead')

@section('content')

@php
    $title_header = "ประวัติอนุมัติคำขออนุมัติ";
    $title_header_table = "รายการประวัติขออนุมัติ";

    $url_approvalgeneral = "head/approvalgeneral";
    $url_approvalgeneral_history = "head/approvalgeneral/history";
    $action_search = "head/approvalgeneral/history/search"; //-- action form
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
            <div class="row">
                <div class="col-sm">
                    <ul class="nav nav-pills nav-fill bg-light pa-10 mb-40" role="tablist">
                        <li class="nav-item">
                            <a href="{{ url($url_approvalgeneral) }}" class="nav-link" style="color: rgb(22, 21, 21);">รายการรออนุมัติ</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($url_approvalgeneral_history) }}" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">ประวัติการอนุมัติ</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            @include('union.approval_general_history_table')

        </section>
    </div>
</div>
<!-- /Row -->

</div>
<!-- /Container -->
@endsection('content')
