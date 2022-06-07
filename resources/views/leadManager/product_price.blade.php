@extends('layouts.masterLead')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">ใบราคา</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i class="ion ion-md-paper"></i> ใบราคา</div>
        </div>
        <!-- /Title -->

        @include('product_price_main')

    </div>
    <!-- /Container -->
@endsection
