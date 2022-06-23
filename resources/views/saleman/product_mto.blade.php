@extends('layouts.master')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">รายการสั่งผลิต (MTO)</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="archive"></i> สินค้าสั่งผลิต (MTO)</div>
        </div>
        <!-- /Title -->

        @include('product_mto_main')

    </div>
    <!-- /Container -->

@endsection
