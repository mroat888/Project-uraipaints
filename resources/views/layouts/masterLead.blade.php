<!DOCTYPE html>
<!--
Template Name: dashgrin - Responsive Bootstrap 4 Admin Dashboard Template
Author: Hencework

License: You must have a valid license purchased only from themeforest to legally use the template for your project.
-->
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Urai Paints</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Style the buttons */
        .btn2 {
          border: none;
          outline: none;
          /* padding: 10px 16px; */
          background-color: #E6E6FA;
          cursor: pointer;
          color: white;
        }
    </style>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{ asset('public/OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/OwlCarousel/owl.theme.default.min.css')}}">

    <!-- FANCYBOX -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">

    <!-- Calendar CSS -->
    {{-- <link href="vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" type="text/css" /> --}}
    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.min.js') }}"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css') }}" />

    <!-- select2 CSS -->
    <link href="{{ asset('public/template/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Data Table CSS -->
    <link href="{{ asset('public/template/vendors/datatables.net-dt/css/jquery.dataTables.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Toggles CSS -->
    <link href="{{ asset('public/template/vendors/jquery-toggles/css/toggles.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('public/template/vendors/jquery-toggles/css/themes/toggles-light.css') }}" rel="stylesheet"
        type="text/css">

    <!-- Morris Charts CSS -->
    <link href="{{ asset('public/template/vendors/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{{ asset('public/template/dist/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/template/dist/css/layout.css') }}" rel="stylesheet" type="text/css">

    <!-- OAT -->
    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <!-- HK Wrapper -->
    <div class="hk-wrapper hk-vertical-nav">

        <?php
                $count_note = App\Note::where('note_date','>=', Carbon\Carbon::now()->format('Y-m-d'))
                    ->where('employee_id', Auth::user()->id)->get();
        ?>

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
            <a class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                href="javascript:void(0);"><span class="feather-icon"><i data-feather="more-vertical"></i></span></a>
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span
                    class="feather-icon"><i data-feather="menu"></i></span></a>
            <a class="navbar-brand" href="{{ url('lead/dashboard') }}">
                <img class="brand-img d-inline-block" src="{{ asset('public/images/logo.png') }}" alt="Uraipaint"
                    style="max-height:30px;" />
                {{-- URAI PAINTS --}}
            </a>
            <ul class="navbar-nav hk-navbar-content order-xl-2">
                <!-- <li class="nav-item">
                    <a id="settings_toggle_btn" class="nav-link nav-link-hover" href="javascript:void(0);"><span
                            class="feather-icon"><i data-feather="settings"></i></span></a>
                </li> -->
                <li class="nav-item dropdown dropdown-notifications">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{-- <span class="feather-icon bell"> --}}
                            <i data-feather="bell"></i><span class="badge badge-danger badge-pill mb-3">{{$count_note->count()}}</span>
                        {{-- </span> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <h6 class="dropdown-header">การแจ้งเตือน</h6>
                        <div class="notifications-nicescroll-bar">
                            @foreach ($count_note as $value)
                            <a href="{{url('leadManage/note')}}" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-primary rounded-circle">
													<span class="initial-wrap"><span><i class="zmdi zmdi-file font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">{{$value->note_title}} <br>
                                                <span class="text-dark text-capitalize"> {!! Str::limit($value->note_detail, 20) !!}<br></span>
                                                {{-- แจ้งเตือนวันที่ <span class="text-dark text-capitalize">{{$value->note_date}}</span> --}}
                                            </div>
                                            <div class="notifications-time">{{$value->note_date}}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            @endforeach
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-body mr-3">
                                <span>{{ Auth::user()->name }}<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                            <div class="media-img-wrap">
                                <div class="avatar">
                                    <img src="{{ asset('public/template/dist/img/avatar12.jpg') }}" alt="user"
                                        class="avatar-img rounded-circle">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX"
                        data-dropdown-out="flipOutX">
                        <a class="dropdown-item" href="{{url('lead/edit-profile')}}"><i
                                class="dropdown-icon zmdi zmdi-account"></i><span>Profile</span></a>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="dropdown-icon zmdi zmdi-power"></i><span>Log out</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

        </nav>
        <form role="search" class="navbar-search">
            <div class="position-relative">
                <a href="javascript:void(0);" class="navbar-search-icon"><span class="feather-icon"><i
                            data-feather="search"></i></span></a>
                <input type="text" name="example-input1-group2" class="form-control"
                    placeholder="Type here to Search">
                <a id="navbar_search_close" class="navbar-search-close" href="#"><span class="feather-icon"><i
                            data-feather="x"></i></span></a>
            </div>
        </form>
        <!-- /Top Navbar -->

        <?php
        $auth_team_id = explode(',',Auth::user()->team_id);
        $auth_team = array();
        foreach($auth_team_id as $value){
            $auth_team[] = $value;
        }
            $monthly_plan = DB::table('monthly_plans')
            ->join('users', 'users.id', 'monthly_plans.created_by')
            ->where('monthly_plans.status_approve', 1)
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select(
                'users.*',
                'monthly_plans.*')->count();

            $request_approval = DB::table('assignments')
            ->join('users', 'assignments.created_by', '=', 'users.id')
            ->where('assignments.assign_status', 0) // สถานะการอนุมัติ (0=รอนุมัติ , 1=อนุมัติ, 2=ปฎิเสธ, 3=สั่งงาน)
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->select('assignments.created_by')
            ->distinct()->count();

            $customers = DB::table('customer_shops_saleplan')
            ->join('customer_shops', 'customer_shops.id', 'customer_shops_saleplan.customer_shop_id')
            ->join('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
            ->where('customer_shops.shop_status', 0)
            ->where('customer_shops_saleplan.shop_aprove_status', 1) // ส่งขออนุมัติ
            ->where(function($query) use ($auth_team) {
                for ($i = 0; $i < count($auth_team); $i++){
                    $query->orWhere('users.team_id', $auth_team[$i])
                        ->orWhere('users.team_id', 'like', $auth_team[$i].',%')
                        ->orWhere('users.team_id', 'like', '%,'.$auth_team[$i]);
                }
            })
            ->where('users.status', 1) // สถานะ 1 = salemam, 2 = lead , 3 = head , 4 = admin
            ->where('customer_shops_saleplan.is_monthly_plan', 'N')
            ->select('customer_shops_saleplan.created_by as shop_created_by')
            ->distinct()->count();

        ?>

        <!-- Vertical Nav -->
        <nav class="hk-nav hk-nav-light">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i
                        data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                <div class="navbar-nav-wrap">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item {{ (request()->is('lead/dashboard')) ? 'btn2' : '' }}">
                            <a class="nav-link" href="{{ url('lead/dashboard') }}">
                                <i class="ion ion-md-home"></i>
                                <span class="nav-link-text">หน้าแรก</span>
                            </a>
                        </li>
                        <li class="nav-item {{ (request()->is('approvalsaleplan')) ? 'btn2' : '' }}">
                            <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" data-target="#planMonth_dropdwon">
                                <i class="ion ion-md-time" style="color: #044067;"></i>
                                <span class="nav-link-text">แผนประจำเดือน</span>
                            </a>
                            <ul id="planMonth_dropdwon" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('approvalsaleplan')) ? 'btn2' : '' }}">
                                            <a class="nav-link link-with-badge" href="{{ url('/approvalsaleplan') }}">
                                                <i class="ion ion-md-today" style="color: #044067;"></i>
                                                <span class="nav-link-text">อนุมัติ Sale Plan</span>
                                                <span class="badge badge-danger badge-pill">{{$monthly_plan}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('customer-api')) ? 'btn2' : '' }} {{ (request()->is('customer')) ? 'btn2' : '' }} {{ (request()->is('lead')) ? 'btn2' : '' }}"
                                href="javascript:void(0);" data-toggle="collapse" data-target="#customer">
                                <i class="ion ion-md-person" style="color: #044067;"></i>
                                <span class="nav-link-text">ลูกค้า</span>
                            </a>
                            <ul id="customer" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <!-- <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('customer') }}">
                                                <i class="ion ion-md-people" style="color: #044067;"></i>
                                                <span class="nav-link-text">ทะเบียนลูกค้า</span>
                                            </a>
                                        </li> -->
                                        <li class="nav-item {{ (request()->is('leadManage/data_name_store')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_name_store') }}">
                                                <i class="ion ion-md-home" style="color: #044067;"></i>ทะเบียนลูกค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('approval-customer-except')) ? 'btn2' : '' }}">
                                            <a class="nav-link link-with-badge" href="{{ url('approval-customer-except') }}">
                                                <i class="ion ion-md-people"></i>
                                                <span class="nav-link-text">อนุมัติลูกค้าใหม่</span>
                                                <span class="badge badge-danger badge-pill">{{$customers}}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_sale_compare-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_sale_compare-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>ข้อมูลลูกค้า (ทำเป้า)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_search_product')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_search_product') }}">
                                                <i class="ion ion-md-search"
                                                    style="color: #044067;"></i>ค้นหาร้านค้า-สินค้า</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ (request()->is('leadManage/reportTeam')) ? 'btn2' : '' }}">
                            <a class="nav-link" href="{{ url('/leadManage/reportTeam') }}">
                                <i class="ion ion-md-stats"></i>ทีมผู้แทนขาย</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('lead/news')) ? 'btn2' : '' }} {{ (request()->is('lead/promotions')) ? 'btn2' : '' }}"
                                href="javascript:void(0);" data-toggle="collapse" data-target="#charts_drp3">
                                <i class="ion ion-md-globe" style="color: #044067;"></i>
                                <span class="nav-link-text">ประกาศ</span>
                            </a>
                            <ul id="charts_drp3" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('lead/news')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('lead/news') }}">
                                                <i class="ion ion-md-wifi" style="color: #044067;"></i>ข่าวสาร</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('lead/promotions')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('lead/promotions') }}">
                                                <i class="ion ion-md-gift" style="color: #044067;"></i>โปรโมชั่น</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('lead/product_new')) ? 'btn2' : '' }} {{ (request()->is('lead/catalog')) ? 'btn2' : '' }}
                                {{ (request()->is('lead/search-productCatalog')) ? 'btn2' : '' }} {{ (request()->is('lead/product_age')) ? 'btn2' : '' }}
                                {{ (request()->is('lead/search-product_age')) ? 'btn2' : '' }} {{ (request()->is('lead/product_mto')) ? 'btn2' : '' }}
                                {{ (request()->is('lead/search-product_mto')) ? 'btn2' : '' }} {{ (request()->is('lead/product_cancel')) ? 'btn2' : '' }}
                                {{ (request()->is('lead/search-product_cancel')) ? 'btn2' : '' }} {{ (request()->is('lead/product_price')) ? 'btn2' : '' }}
                                {{ (request()->is('lead/search-product_price')) ? 'btn2' : '' }}"
                                href="javascript:void(0);" data-toggle="collapse" data-target="#products_dropdwon">
                                <i class="ion ion-md-cube" style="color: #044067;"></i>
                                <span class="nav-link-text">สินค้า</span>
                            </a>
                            <ul id="products_dropdwon" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item {{ (request()->is('lead/product_new')) ? 'btn2' : '' }}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('lead/product_new') }}">
                                                <i class="ion ion-md-star" style="color: #044067;"></i>สินค้าใหม่</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ (request()->is('lead/catalog')) ? 'btn2' : '' }} {{ (request()->is('lead/search-productCatalog')) ? 'btn2' : '' }}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('lead/catalog') }}">
                                                <i class="ion ion-md-grid" style="color: #044067;"></i>แคตตาล๊อคสินค้า</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ (request()->is('lead/product_age')) ? 'btn2' : '' }} {{ (request()->is('lead/search-product_age')) ? 'btn2' : '' }}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('lead/product_age') }}">
                                                <i class="material-icons">work_history</i> อายุจัดเก็บ</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ (request()->is('lead/product_mto')) ? 'btn2' : '' }} {{ (request()->is('lead/search-product_mto')) ? 'btn2' : '' }}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('lead/product_mto') }}">
                                                <i class="material-icons">inventory</i> รายการสั่งผลิต (MTO)</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ (request()->is('lead/product_cancel')) ? 'btn2' : '' }} {{ (request()->is('lead/search-product_cancel')) ? 'btn2' : '' }}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('lead/product_cancel') }}">
                                                <i class="material-icons">restart_alt</i> รายการสินค้ายกเลิก</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item {{ (request()->is('lead/product_price')) ? 'btn2' : '' }} {{ (request()->is('lead/search-product_price')) ? 'btn2' : '' }}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('lead/product_price') }}">
                                                <i class="material-icons">receipt_long</i> ใบราคา</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('approvalgeneral')) ? 'btn2' : '' }}
                                {{ (request()->is('approval-customer-except')) ? 'btn2' : '' }} {{ (request()->is('add_assignment')) ? 'btn2' : '' }}"
                                href="javascript:void(0);" data-toggle="collapse" data-target="#charts_drp2">
                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                <span class="nav-link-text">ขออนุมัติ และสั่งงาน</span>
                                <span class="badge badge-danger badge-pill ml-2">{{$monthly_plan + $request_approval}}</span>
                            </a>
                            <ul id="charts_drp2" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">

                                        <li class="nav-item {{ (request()->is('approvalgeneral')) ? 'btn2' : '' }}">
                                            <a class="nav-link link-with-badge" href="{{ url('/approvalgeneral') }}">
                                                <i class="ion ion-md-checkbox"></i>
                                                <span class="nav-link-text">อนุมัติคำขออนุมัติ</span>
                                                <span class="badge badge-danger badge-pill">{{$request_approval}}</span>
                                            </a>
                                        </li>

                                        <li class="nav-item {{ (request()->is('add_assignment')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('add_assignment') }}">
                                                <i class="ion ion-md-folder-open" style="color: #044067;"></i>
                                                สั่งงานผู้แทนขาย</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ (request()->is('leadManage/note')) ? 'btn2' : '' }}">
                            <a class="nav-link link-with-badge" href="{{ url('/leadManage/note') }}">
                                <i class="ion ion-md-document"></i>
                                <span class="nav-link-text">บันทึกโน้ต</span>
                                <span class="badge badge-danger badge-pill">{{$count_note->count()}}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('leadManage/data_name_store')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_search_product')) ? 'btn2' : '' }}
                                {{ (request()->is('leadManage/data_report_product-new')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_report_full-year')) ? 'btn2' : '' }}
                                {{ (request()->is('leadManage/data_report_historical-year')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_report_historical-quarter')) ? 'btn2' : '' }}
                                {{ (request()->is('leadManage/data_report_historical-month')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_report_sale_compare-year')) ? 'btn2' : '' }}"
                            href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp_data">
                                <i class="ion ion-md-book" style="color: #044067;"></i>
                                <span class="nav-link-text">รายงานยอดขาย</span>
                            </a>
                            <ul id="charts_drp_data" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_product-new')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_product-new') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานยอดขายสินค้าใหม่</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_full-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_full-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานขายตามหมวดสินค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_historical-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_historical-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>สรุปยอดขาย (รายปี)</a>
                                        </li>
                                        <!-- <li class="nav-item {{ (request()->is('leadManage/data_report_historical-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_historical-quarter') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (Quarter)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_historical-month')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_historical-month') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (รายเดือน)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_sale_compare-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_sale_compare-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานสรุปยอดทำเป้า เทียบปี</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <li class="nav-item {{ (request()->is('leadManage/data_report_customer_compare-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_customer_compare-year') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>ยอดขายร้านค้า เทียบปีต่อปี
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <li class="nav-item {{ (request()->is('leadManage/data_report_product_return')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_product_return') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานรับคืนสินค้า
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- <li class="nav-item">
                            <a class="nav-link {{ (request()->is('leadManage/reportStore')) ? 'btn2' : '' }}
                                {{ (request()->is('leadManage/reportSaleplan')) ? 'btn2' : '' }} {{ (request()->is('leadManage/reportYear')) ? 'btn2' : '' }}"
                            href="javascript:void(0);" data-toggle="collapse" data-target="#charts_drp">
                                <i class="ion ion-md-stats"></i>
                                <span class="nav-link-text">รายงาน</span>
                            </a>
                            <ul id="charts_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('leadManage/reportStore')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/leadManage/reportStore') }}">
                                                <i class="ion ion-md-stats"></i>รายงานสรุปยอดร้านค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/reportTeam')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/leadManage/reportTeam') }}">
                                                <i class="ion ion-md-stats"></i>รายงานลูกทีมที่รับผิดชอบ</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/reportSaleplan')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('/leadManage/reportSaleplan') }}">
                                                <i class="ion ion-md-stats"></i>รายงานสรุปแผนประจำเดือน</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/reportYear')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/leadManage/reportYear') }}">
                                                <i class="ion ion-md-stats"></i>รายงานสรุปข้อมูลประจำปี</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <hr class="nav-separator">
                    <div class="nav-header">
                        <span>ข้อมูลที่ใช้ร่วมกัน</span>
                        <span>DATA</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('leadManage/data_name_store')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_search_product')) ? 'btn2' : '' }}
                                {{ (request()->is('leadManage/data_report_product-new')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_report_full-year')) ? 'btn2' : '' }}
                                {{ (request()->is('leadManage/data_report_historical-year')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_report_historical-quarter')) ? 'btn2' : '' }}
                                {{ (request()->is('leadManage/data_report_historical-month')) ? 'btn2' : '' }} {{ (request()->is('leadManage/data_report_sale_compare-year')) ? 'btn2' : '' }}"
                            href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp_data">
                                <i class="ion ion-md-book" style="color: #044067;"></i>
                                <span class="nav-link-text">การดูข้อมูล (ใช้ร่วมกัน)</span>
                            </a>
                            <ul id="charts_drp_data" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('leadManage/data_name_store')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_name_store') }}">
                                                <i class="ion ion-md-home" style="color: #044067;"></i>ตรวจสอบรายชื่อร้านค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_search_product')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_search_product') }}">
                                                <i class="ion ion-md-search"
                                                    style="color: #044067;"></i>ค้นหารายการสินค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_product-new')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_product-new') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานยอดขายสินค้าใหม่</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_full-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_full-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานสรุปยอด (ทั้งปี)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_historical-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_historical-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (ทั้งปี)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_historical-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_historical-quarter') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (Quarter)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_historical-month')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_historical-month') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (รายเดือน)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('leadManage/data_report_sale_compare-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('leadManage/data_report_sale_compare-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานสรุปยอดทำเป้า เทียบปี</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul> -->
                </div>
            </div>
        </nav>
        <div id="hk_nav_backdrop" class="hk-nav-backdrop"></div>
        <!-- /Vertical Nav -->

        <!-- Setting Panel -->
        <div class="hk-settings-panel">
            <div class="nicescroll-bar position-relative">
                <div class="settings-panel-wrap">
                    <div class="settings-panel-head">
                        <img class="brand-img d-inline-block align-top" src="{{ asset('dist/img/logo-light.png') }}"
                            alt="brand" />
                        <a href="javascript:void(0);" id="settings_panel_close" class="settings-panel-close"><span
                                class="feather-icon"><i data-feather="x"></i></span></a>
                    </div>

                    <hr>
                    <h6 class="mb-5">Navigation</h6>
                    <p class="font-14">Menu comes in two modes: dark & light</p>
                    <div class="button-list hk-nav-select mb-10">
                        <button type="button" id="nav_light_select"
                            class="btn btn-outline-success btn-sm btn-wth-icon icon-wthot-bg"><span
                                class="icon-label"><i class="fa fa-sun-o"></i> </span><span
                                class="btn-text">Light Mode</span></button>
                        <button type="button" id="nav_dark_select"
                            class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span
                                class="icon-label"><i class="fa fa-moon-o"></i> </span><span
                                class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <h6 class="mb-5">Top Nav</h6>
                    <p class="font-14">Choose your liked color mode</p>
                    <div class="button-list hk-navbar-select mb-10">
                        <button type="button" id="navtop_light_select"
                            class="btn btn-outline-light btn-sm btn-wth-icon icon-wthot-bg"><span
                                class="icon-label"><i class="fa fa-sun-o"></i> </span><span
                                class="btn-text">Light Mode</span></button>
                        <button type="button" id="navtop_dark_select"
                            class="btn btn-outline-success btn-sm btn-wth-icon icon-wthot-bg"><span
                                class="icon-label"><i class="fa fa-moon-o"></i> </span><span
                                class="btn-text">Dark Mode</span></button>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Scrollable Header</h6>
                        <div class="toggle toggle-sm toggle-simple toggle-light toggle-bg-success scroll-nav-switch">
                        </div>
                    </div>
                    <button id="reset_settings" class="btn btn-success btn-block btn-reset mt-30">Reset</button>
                </div>
            </div>
            <img class="d-none" src="{{ asset('public/template/dist/img/logo-light.png') }}" alt="brand" />
            <img class="d-none" src="{{ asset('public/template/dist/img/logo-dark.png') }}" alt="brand" />
        </div>
        <!-- /Setting Panel -->

        <!-- Main Content -->
        <div class="hk-pg-wrapper">
            @yield('content')

            <!-- Footer -->
            <div class="hk-footer-wrap container-fluid px-xxl-65 px-xl-20">
                @yield('footer')
            </div>
            <!-- /Footer -->
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /HK Wrapper -->

    @if(isset($disable_jquery))
        <!-- Select2 JavaScript -->
        <script src="{{ asset('public/template/vendors/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('public/template/dist/js/select2-data.js') }}"></script>

        <!-- jQuery -->
        <script src="{{ asset('public/template/vendors/jquery/dist/jquery.min.js') }}"></script>
    @else 
        <!-- jQuery -->
        <script src="{{ asset('public/template/vendors/jquery/dist/jquery.min.js') }}"></script>

        <!-- Select2 JavaScript -->
        <script src="{{ asset('public/template/vendors/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('public/template/dist/js/select2-data.js') }}"></script>
    @endif

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('public/template/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('public/template/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('public/template/dist/js/jquery.slimscroll.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('public/template/dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{ asset('public/template/vendors/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('public/template/vendors/morris.js/morris.min.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/linecharts-data.js') }}"></script>

    <!-- EChartJS JavaScript -->
    <script src="{{ asset('public/template/vendors/echarts/dist/echarts-en.min.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/piecharts-data.js') }}"></script>

    <!-- Easy pie chart JS -->
    <script src="{{ asset('public/template/vendors/easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/easypiechart-data.js') }}"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="{{ asset('public/template/dist/js/feather.min.js') }}"></script>

    <!-- Toggles JavaScript -->
    <script src="{{ asset('public/template/vendors/jquery-toggles/toggles.min.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/toggle-data.js') }}"></script>

    <!-- Counter Animation JavaScript -->
    <script src="{{ asset('public/template/vendors/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('public/template/vendors/jquery.counterup/jquery.counterup.min.js') }}"></script>

    <!-- Sparkline JavaScript -->
    <script src="{{ asset('public/template/vendors/jquery.sparkline/dist/jquery.sparkline.min.js') }}"></script>

    <!-- Vector Maps template -->
    <script src="{{ asset('public/template/vendors/vectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('public/template/vendors/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/vectormap-data.js') }}"></script>

    <!-- Owl JavaScript -->
    <script src="{{ asset('public/template/vendors/owl.carousel/dist/owl.carousel.min.js') }}"></script>

    <!-- Owl Init JavaScript -->
    <script src="{{ asset('public/template/dist/js/owl-data.js') }}"></script>

    <!-- Bootstrap Tagsinput JavaScript -->
    {{-- <script src="{{asset('public/template/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script> --}}

    <!-- Jasny-bootstrap  JavaScript -->
    <script src="{{ asset('public/template/vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js') }}"></script>

    <!-- Data Table JavaScript -->
    <script src="{{ asset('public/template/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('public/template/dist/js/dataTables-data.js') }}"></script>
    <script src="{{ asset('public/template/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>



    <!-- Init JavaScript -->
    <script src="{{ asset('public/template/dist/js/init.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/gmap-data.js') }}"></script>

    <!-- OwlCarousel -->
    <script src="{{ asset('public/OwlCarousel/owl.carousel.min.js')}}"></script>
    <!-- FANCYBOX -->
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>


    <script type="text/javascript">
        $('.detail_slide').each(function(){
            (function(_e){
        var sync1 = $(_e).find(".slider");
        var sync2 = $(_e).find(".navigation-thumbs");

        var thumbnailItemClass = '.owl-item';

        var slides = sync1.owlCarousel({
            video: true,
            startPosition: 0,
            items: 1,
            animateOut: 'fadeOut',
            loop: false,
            rewind: true,
            margin: 0,
            autoplay: false,
            autoplayHoverPause: true,
            autoplayTimeout: 7000,
            smartSpeed: 500,
            autoplayHoverPause: true,
            navText: [
                '<span><i class="fas fa-chevron-left"></i></span>',
                '<span><i class="fas fa-chevron-right"></i></span>'
            ],
            nav: true,
            dots: false
        }).on('changed.owl.carousel', syncPosition);

        function syncPosition(el) {
            $owl_slider = $(this).data('owl.carousel');
            var loop = $owl_slider.options.loop;

            if(loop){
            var count = el.item.count-1;
            var current = Math.round(el.item.index - (el.item.count/2) - .5);
            if(current < 0) {
                current = count;
            }
            if(current > count) {
                current = 0;
            }
            }else{
            var current = el.item.index;

            }
            console.log(current);

            var owl_thumbnail = sync2.data('owl.carousel');
            var itemClass = "." + owl_thumbnail.options.itemClass;


            var thumbnailCurrentItem = sync2
            .find(itemClass)
            .removeClass("synced")
            .eq(current);

            thumbnailCurrentItem.addClass('synced');

            //if (!thumbnailCurrentItem.hasClass('active')) {
            var duration = 300;
            sync2.trigger('to.owl.carousel',[current-2, duration, true]);
            //}
        }
        var thumbs = sync2.owlCarousel({
            startPosition: 0,
            items: 4,
            loop: false,
            margin: 10,
            autoplay: false,
            autoplayHoverPause: true,
            nav: true,
            navText: false,
            dots: false,
            responsive:{
                0:{
                    items: 3,
                    margin: 5
                },
                500:{
                    margin: 5
                },
                768:{
                    margin: 5
                },
                1201:{
                    margin: 10
                }
            },
            onInitialized: function (e) {
            var thumbnailCurrentItem =  $(e.target).find(thumbnailItemClass).eq(this._current);
            thumbnailCurrentItem.addClass('synced');
            },
        })

        .on('click', thumbnailItemClass, function(e) {
            e.preventDefault();
            var duration = 300;
            var itemIndex =  $(e.target).parents(thumbnailItemClass).index();
            sync1.trigger('to.owl.carousel',[itemIndex, duration, true]);
        }).on("changed.owl.carousel", function (el) {
            //var number = el.item.index;
            //$owl_slider = sync1.data('owl.carousel');
            //$owl_slider.to(number, 100, true);
        });
        })(this);
        });

    </script>

</body>

</html>
