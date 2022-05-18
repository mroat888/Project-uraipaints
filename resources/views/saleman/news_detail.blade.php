@extends('layouts.master')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item">ข้อมูลข่าวสาร</li>
            <li class="breadcrumb-item active">รายละเอียดข่าวสาร</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="file-text"></i> รายละเอียดข่าวสาร</div>
            <div class="content-right d-flex">
                <a href="{{ url('news')}}" type="button" class="btn btn-secondary btn-rounded"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

        @include('news_main_detail')

    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
