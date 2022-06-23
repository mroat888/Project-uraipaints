@extends('layouts.master')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">รายการสินค้ายกเลิก</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-sync"></i> สินค้ายกเลิก</div>
        </div>
        <!-- /Title -->

        @include('product_cancel_main')

    </div>
    <!-- /Container -->

@endsection
