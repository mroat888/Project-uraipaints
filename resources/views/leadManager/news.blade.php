@extends('layouts.masterLead')

@section('content')

   <!-- Breadcrumb -->
   <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">ข่าวสาร</li>
    </ol>
</nav>
<!-- /Breadcrumb -->


    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="file-text"></i> ข่าวสาร</div>
            <div class="content-right d-flex">
            </div>
        </div>
        <!-- /Title -->

        @include('news_main')

    </div>
    <!-- /Container -->
    
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

