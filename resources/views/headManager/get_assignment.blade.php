@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">งานที่ได้รับมอบหมาย</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><span class="pg-title-icon"><i class="ion ion-md-clipboard"></i></span> งานที่ได้รับมอบหมาย</div>
            <div class="content-right d-flex">
            </div>
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
                                        <a href="{{url('head/assignment/add')}}" class="nav-link" style="color: rgb(22, 21, 21);">สั่งงานผู้จัดการเขต และ ผู้แทนขาย</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" style="background: rgb(5, 90, 97); color:rgb(255, 255, 255);">งานที่ได้รับมอบหมาย</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @php
                        $action_search = "lead/search_month_get-assignment";
                    @endphp

                    @include('union.assignment_submitwork_manager')
                </section>
        </div>
        <!-- /Row -->
    </div>


@endsection

@section('footer')
    @include('layouts.footer')
@endsection('footer')

