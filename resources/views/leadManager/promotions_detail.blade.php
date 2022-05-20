@extends('layouts.masterLead')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item">โปรโมชั่น</li>
            <li class="breadcrumb-item active">รายละเอียดโปรโมชั่น</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="file-text"></i> รายละเอียดโปรโมชั่น</div>
            <div class="content-right d-flex">
                <a href="{{ url('lead/promotions')}}" type="button" class="btn btn-secondary btn-rounded"> ย้อนกลับ </a>
            </div>
        </div>

        @include('promotion_main_detail')

    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
