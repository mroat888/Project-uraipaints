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

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

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

        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-xl navbar-light fixed-top hk-navbar">
            <a class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                href="javascript:void(0);"><span class="feather-icon"><i data-feather="more-vertical"></i></span></a>
            <a id="navbar_toggle_btn" class="navbar-toggle-btn nav-link-hover" href="javascript:void(0);"><span
                    class="feather-icon"><i data-feather="menu"></i></span></a>
            <a class="navbar-brand" href="index.html">
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
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><span class="feather-icon bell"><i
                                data-feather="bell"></i></span></a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn"
                        data-dropdown-out="fadeOut">
                        <h6 class="dropdown-header">Notifications <a href="javascript:void(0);"
                                class="">View all</a></h6>
                        <div class="notifications-nicescroll-bar">
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('public/template/dist/img/avatar1.jpg') }}"
                                                alt="user" class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text"><span class="text-dark text-capitalize">Evie
                                                    Ono</span> accepted your invitation to join the team</div>
                                            <div class="notifications-time">12m</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <img src="{{ asset('public/template/dist/img/avatar1.jpg') }}"
                                                alt="user" class="avatar-img rounded-circle">
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">New message received from <span
                                                    class="text-dark text-capitalize">Misuko Heid</span></div>
                                            <div class="notifications-time">1h</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-primary rounded-circle">
                                                <span class="initial-wrap"><span><i
                                                            class="zmdi zmdi-account font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">You have a follow up with<span
                                                    class="text-dark text-capitalize"> dashgrin head</span> on <span
                                                    class="text-dark text-capitalize">friday, dec 19</span> at <span
                                                    class="text-dark">10.00 am</span></div>
                                            <div class="notifications-time">2d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-success rounded-circle">
                                                <span class="initial-wrap"><span>A</span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Application of <span
                                                    class="text-dark text-capitalize">Sarah Williams</span> is waiting
                                                for your approval</div>
                                            <div class="notifications-time">1w</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item">
                                <div class="media">
                                    <div class="media-img-wrap">
                                        <div class="avatar avatar-sm">
                                            <span class="avatar-text avatar-text-warning rounded-circle">
                                                <span class="initial-wrap"><span><i
                                                            class="zmdi zmdi-notifications font-18"></i></span></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div>
                                            <div class="notifications-text">Last 2 days left for the project</div>
                                            <div class="notifications-time">15d</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-authentication">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="media">
                            <div class="media-img-wrap">
                                <div class="avatar">
                                    <img src="{{ asset('public/template/dist/img/avatar12.jpg') }}" alt="user"
                                        class="avatar-img rounded-circle">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>
                            <div class="media-body">
                                <span>{{ Auth::user()->name }}<i class="zmdi zmdi-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX"
                        data-dropdown-out="flipOutX">
                        <a class="dropdown-item" href="profile.html"><i
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
        <!-- /Top Navbar -->

        <!-- Vertical Nav -->
        <nav class="hk-nav hk-nav-light">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i
                        data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                <div class="navbar-nav-wrap">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('dashboard') }}">
                                <i class="ion ion-md-home" style="color: #044067;"></i>
                                <span class="nav-link-text">หน้าแรก</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('planMonth') }}">
                                <i class="ion ion-md-time" style="color: #044067;"></i>
                                <span class="nav-link-text">แผนประจำเดือน</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('dailyWork') }}">
                                <i class="ion ion-md-star" style="color: #044067;"></i>
                                <span class="nav-link-text">งานประจำวัน</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('palncalendar') }}">
                                <i class="ion ion-md-calendar" style="color: #044067;"></i>
                                <span class="nav-link-text">ปฎิทินกิจกรรม</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp2">
                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                <span class="nav-link-text">ขออนุมัติ และ สั่งงาน</span>
                            </a>
                            <ul id="charts_drp2" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('approval') }}">
                                                <i class="ion ion-md-clipboard" style="color: #044067;"></i>
                                                บันทึกขออนุมัติ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('assignment') }}">
                                                <i class="ion ion-md-flag" style="color: #044067;"></i>
                                                รายการสั่งงาน</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="{{ url('saleplan') }}">
                                                <i class="ion ion-md-calendar" style="color: #044067;"></i>
                                                <span class="nav-link-text">Sale plan</span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('saleplan') }}">
                                <i class="ion ion-md-calendar" style="color: #044067;"></i>
                                <span class="nav-link-text">Sale plan</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('assignment') }}">
                                <i class="ion ion-md-clipboard" style="color: #044067;"></i>
                                <span class="nav-link-text">งานที่ได้รับมอบหมาย</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('/lead') }}">
                                <i class="ion ion-md-person" style="color: #044067;"></i>
                                <span class="nav-link-text">ลูกค้าเป้าหมาย</span>
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('customer') }}">
                                <i class="ion ion-md-people" style="color: #044067;"></i>
                                <span class="nav-link-text">ทะเบียนลูกค้า</span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#customer">
                                <i class="ion ion-md-person" style="color: #044067;"></i>
                                <span class="nav-link-text">ลูกค้า</span>
                            </a>
                            <ul id="customer" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('customer') }}">
                                                <i class="ion ion-md-people" style="color: #044067;"></i>
                                                <span class="nav-link-text">ทะเบียนลูกค้า</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('/lead') }}">
                                                <i class="ion ion-md-person-add" style="color: #044067;"></i>
                                                <span class="nav-link-text">ลูกค้าเป้าหมาย</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('visit') }}">
                                                <i class="ion ion-md-swap" style="color: #044067;"></i>
                                                <span class="nav-link-text">เข้าเยี่ยมลูกค้า</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('visit') }}">
                                <i class="ion ion-md-appstore" style="color: #044067;"></i>
                                <span class="nav-link-text">การเข้าเยี่ยมลูกค้า</span>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ url('approval') }}">
                                <i class="ion ion-md-paper"></i>
                                <span class="nav-link-text">การขออนุมัติ</span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link link-with-badge" href="{{ url('note') }}">
                                <i class="ion ion-md-document" style="color: #044067;"></i>
                                <span class="nav-link-text">บันทึกโน้ต</span>
                                <?php
                                // $count_note = App\Note::where('')->count();
                                 ?>
                                <span class="badge badge-danger badge-pill">2</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp3">
                                <i class="ion ion-md-globe" style="color: #044067;"></i>
                                <span class="nav-link-text">ข่าวสาร และ โปรโมชั่น</span>
                            </a>
                            <ul id="charts_drp3" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('news') }}">
                                                <i class="ion ion-md-wifi" style="color: #044067;"></i>ข่าวสาร</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('promotions') }}">
                                                <i class="ion ion-md-gift" style="color: #044067;"></i>โปรโมชั่น</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp">
                                <i class="ion ion-md-stats" style="color: #044067;"></i>
                                <span class="nav-link-text">รายงาน</span>
                            </a>
                            <ul id="charts_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ url('/reportSale/reportSaleplan') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงาน sale
                                                plan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ url('/reportSale/reportVisitCustomerGoal') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเข้าพบลูกค้าเป้าหมาย</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link"
                                                href="{{ url('/reportSale/reportVisitCustomer') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเข้าพบลูกค้า</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <hr class="nav-separator">
                    <div class="nav-header">
                        <span>ผู้จัดการ</span>
                        <span>MG</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('leadManage') }}">
                                <i class="ion ion-md-bookmarks" style="color: #044067;"></i>
                                <span class="nav-link-text">ผู้จัดการเขต</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('headManage') }}">
                                <i class="ion ion-md-bookmarks" style="color: #044067;"></i>
                                <span class="nav-link-text">ผู้จัดการฝ่าย</span>
                            </a>
                        </li>
                    </ul>
                    <hr class="nav-separator">
                    <div class="nav-header">
                        <span>ผู้ดูแล</span>
                        <span>AM</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin') }}">
                                <i class="ion ion-md-bookmarks" style="color: #044067;"></i>
                                <span class="nav-link-text">ผู้ดูแล</span>
                            </a>
                        </li>
                    </ul>
                    <hr class="nav-separator">
                    <div class="nav-header">
                        <span>รายงาน</span>
                        <span>RP</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('#') }}">
                                <i class="ion ion-md-bookmarks" style="color: #044067;"></i>
                                <span class="nav-link-text">รายงาน(ใช้ร่วมกัน)</span>
                            </a>
                        </li>
                    </ul>
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
                        <img class="brand-img d-inline-block align-top"
                            src="{{ asset('public/template/dist/img/logo-light.png') }}" alt="brand" />
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

    <!-- jQuery -->
    <script src="{{ asset('public/template/vendors/jquery/dist/jquery.min.js') }}"></script>

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

    <!-- Select2 JavaScript -->
    <script src="{{ asset('public/template/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/select2-data.js') }}"></script>

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

    <!-- Gmap JavaScript -->
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBazijMOj67rUPPtVybwi2Nbo90tx7vwZs">
    </script>

    <!-- Init JavaScript -->
    <script src="{{ asset('public/template/dist/js/init.js') }}"></script>
    <script src="{{ asset('public/template/dist/js/gmap-data.js') }}"></script>

    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>





</body>

</html>
