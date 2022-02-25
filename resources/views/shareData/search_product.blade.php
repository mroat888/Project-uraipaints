@extends('layouts.master')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item active">ค้นหารายการสินค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div>
                            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                            data-feather="search"></i></span></span>ค้นหารายการสินค้า</h4>
                        </div>
                        <div class="d-flex">
                            {{-- <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal"
                                data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
                                <input type="text" class="form-control" placeholder="ค้นหารายการสินค้า">
                                <button type="button" class="btn btn-teal btn-sm px-3 ml-2">ค้นหา</button>
                        </div>
                    </div>
                    {{-- <p class="mb-40">ข้อมูลรายการสินค้า</p> --}}
                    <div class="row">
                        <div class="col-sm">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="card mb-20">
                                        <img class="card-img-top" src="{{ asset('public/dist/img/cropper.jpg')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Image top</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="card mb-20">
                                        <img class="card-img-top" src="{{ asset('public/dist/img/cropper.jpg')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Image top</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="card mb-20">
                                        <img class="card-img-top" src="{{ asset('public/dist/img/cropper.jpg')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Image top</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="card mb-20">
                                        <img class="card-img-top" src="{{ asset('public/dist/img/cropper.jpg')}}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">Image top</h5>
                                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div> --}}
                                <nav class="pagination-wrap d-inline-block mt-30 float-right" aria-label="Page navigation example">
                                    <ul class="pagination custom-pagination">
                                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item active active-gold"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item"><a class="page-link" href="#">15</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            {{-- </div> --}}
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </div>
    <!-- /Container -->

@section('footer')
    @include('layouts.footer')
@endsection

@endsection
