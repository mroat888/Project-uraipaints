@extends('layouts.masterHead')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item">สินค้า</li>
        <li class="breadcrumb-item">แคตตาล็อกสินค้า</li>
        <li class="breadcrumb-item active">รายละเอียดแคตตาล็อกสินค้า</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        @include('catalog_main_detail')
    </div>
    <!-- /Container -->

@section('footer')
@include('layouts.footer')
@endsection
@endsection
