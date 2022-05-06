<!DOCTYPE html>
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

    <!-- Calendar CSS -->
    {{-- <link href="vendors/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" type="text/css" /> --}}
    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.min.js') }}" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css') }}" />

    <!-- select2 CSS -->
    <link href="{{ asset('public/template/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Data Table CSS -->
    <link href="{{ asset('public/template/vendors/datatables.net-dt/css/jquery.dataTables.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/template/vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Morris Charts CSS -->
    <link href="{{ asset('public/template/vendors/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{{ asset('/public/template/dist/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/public/template/dist/css/layout.css') }}" rel="stylesheet" type="text/css">

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
            <a class="navbar-brand" href="{{ url('admin') }}">
                <img class="brand-img d-inline-block" src="{{ asset('public/images/logo.png') }}" alt="Uraipaint" style="max-height:30px;"/>
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
                            <a href="{{url('admin/note')}}" class="dropdown-item">
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
                                    <img src="{{ asset('public/template/dist/img/avatar12.jpg') }}" alt="user" class="avatar-img rounded-circle">
                                </div>
                                <span class="badge badge-success badge-indicator"></span>
                            </div>

                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="flipInX"
                        data-dropdown-out="flipOutX">
                        <a class="dropdown-item" href="{{ url('admin/edit-profile')}}"><i
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

        <!-- Vertical Nav -->
        <nav class="hk-nav hk-nav-light">
            <a href="javascript:void(0);" id="hk_nav_close" class="hk-nav-close"><span class="feather-icon"><i
                        data-feather="x"></i></span></a>
            <div class="nicescroll-bar">
                <div class="navbar-nav-wrap">
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item {{ (request()->is('admin')) ? 'btn2' : '' }}">
                            <a class="nav-link" href="{{ url('admin') }}">
                                <i class="ion ion-md-home" style="color: #044067;"></i>
                                <span class="nav-link-text">หน้าแรก</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/approvalsaleplan')) ? 'btn2' : '' }}" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#planMonth_dropdwon">
                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                <span class="nav-link-text">แผนประจำเดือน</span>
                            </a>
                            <ul id="planMonth_dropdwon" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/approvalsaleplan')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/approvalsaleplan') }}">
                                                <i class="ion ion-md-today" style="color: #044067;"></i>
                                                ปิด Sale plan</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/data_name_store')) ? 'btn2' : '' }} {{ (request()->is('lead')) ? 'btn2' : '' }}" href="javascript:void(0);"
                                data-toggle="collapse" data-target="#customer_dropdwon">
                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                <span class="nav-link-text">ลูกค้า</span>
                            </a>
                            <ul id="customer_dropdwon" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/data_name_store')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_name_store') }}">
                                                <i class="ion ion-md-home" style="color: #044067;"></i>ทะเบียนลูกค้า
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/change_customer_status')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/change_customer_status') }}">
                                                <i class="ion ion-md-person-add" style="color: #044067;"></i>เปลี่ยนสถานะลูกค้าใหม่
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('data_report_sale_compare-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_sale_compare-year') }}">
                                                <i class="ion ion-md-stats"style="color: #044067;"></i>ข้อมูลลูกค้า (ทำเป้า)
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_search_product')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_search_product') }}">
                                                <i class="ion ion-md-search" style="color: #044067;"></i>ค้นหาร้านค้า-สินค้า
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/news')) ? 'btn2' : '' }} {{ (request()->is('admin/pomotion')) ? 'btn2' : '' }}" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#information_dropdwon">
                                <i class="ion ion-md-globe" style="color: #044067;"></i>
                                <span class="nav-link-text">ประกาศ</span>
                            </a>
                            <ul id="information_dropdwon" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/news')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/news') }}">
                                                <i class="ion ion-md-wifi" style="color: #044067;"></i>
                                                <span class="nav-link-text">แจ้งข่าวสาร</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/pomotion')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/pomotion') }}">
                                                <i class="ion ion-md-gift" style="color: #044067;"></i>
                                                <span class="nav-link-text">โปรโมชั่น</span>
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item {{ (request()->is('admin/fontendNews')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/fontendNews') }}">
                                                <i class="ion ion-md-wifi" style="color: #044067;"></i>ข่าวสาร</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/fontendPromotions')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/fontendPromotions') }}">
                                                <i class="ion ion-md-gift" style="color: #044067;"></i>โปรโมชั่น</a>
                                        </li>
                                        <li class="nav-item">
                                            <ul class="nav flex-column">
                                                <li class="nav-item {{ (request()->is('admin/fontendProductNew')) ? 'btn2' : '' }}">
                                                    <a class="nav-link" href="{{ url('admin/fontendProductNew') }}">
                                                        <i class="ion ion-md-cube" style="color: #044067;"></i>สินค้าใหม่</a>
                                                </li>
                                            </ul>
                                        </li> -->
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('product_new')) ? 'btn2' : '' }}"
                                href="javascript:void(0);" data-toggle="collapse" data-target="#products_dropdwon">
                                <i class="ion ion-md-globe" style="color: #044067;"></i>
                                <span class="nav-link-text">สินค้า</span>
                            </a>
                            <ul id="products_dropdwon" class="nav flex-column collapse collapse-level-1">

                                <li class="nav-item {{ (request()->is('admin/product_new')) ? 'btn2' : '' }}">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ url('admin/product_new') }}">
                                                <i class="ion ion-md-cube" style="color: #044067;"></i>สินค้าใหม่</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <i class="ion ion-md-cube" style="color: #044067;"></i>แคตตาล๊อคสินค้า</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <i class="ion ion-md-cube" style="color: #044067;"></i>อายุจัดเก็บ</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <i class="ion ion-md-cube" style="color: #044067;"></i>รายการสั่งผลิต (MTO)</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <i class="ion ion-md-cube" style="color: #044067;"></i>รายการสินค้ายกเลิก</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <i class="ion ion-md-cube" style="color: #044067;"></i>ใบราคา</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/approvalsaleplan')) ? 'btn2' : '' }} {{ (request()->is('admin/approvalgeneral')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/approval-customer-except')) ? 'btn2' : '' }} {{ (request()->is('admin/assignment-add')) ? 'btn2' : '' }}" href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp2">
                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                <span class="nav-link-text">สั่งงาน</span>
                            </a>
                            <ul id="charts_drp2" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <!-- <li class="nav-item {{ (request()->is('admin/approvalsaleplan')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/approvalsaleplan') }}">
                                                <i class="ion ion-md-today" style="color: #044067;"></i>
                                                อนุมัติ sale plan</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/approvalgeneral')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/approvalgeneral') }}">
                                                <i class="ion ion-md-checkbox"></i>
                                                <span class="nav-link-text">อนุมัติคำขออนุมัติ</span>
                                            </a>
                                        </li> -->
                                        <li class="nav-item {{ (request()->is('admin/assignment-add')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/assignment-add') }}">
                                                <i class="ion ion-md-folder-open" style="color: #044067;"></i>
                                                สั่งงาน ผจก. และผู้แทนขาย</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ (request()->is('admin/note')) ? 'btn2' : '' }}">
                            <a class="nav-link link-with-badge" href="{{ url('admin/note') }}">
                                <i class="ion ion-md-document" style="color: #044067;"></i>
                                <span class="nav-link-text">บันทึกโน้ต</span>
                                <span class="badge badge-danger badge-pill">{{$count_note->count()}}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/data_name_store')) ? 'btn2' : '' }} {{ (request()->is('admin/data_search_product')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/data_report_product-new')) ? 'btn2' : '' }} {{ (request()->is('admin/data_report_full-year')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/data_report_historical-year')) ? 'btn2' : '' }} {{ (request()->is('admin/data_report_historical-quarter')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/data_report_historical-month')) ? 'btn2' : '' }} {{ (request()->is('admin/data_report_sale_compare-year')) ? 'btn2' : '' }}"
                            href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp_data">
                                <i class="ion ion-md-book" style="color: #044067;"></i>
                                <span class="nav-link-text">รายงานยอดขาย</span>
                            </a>
                            <ul id="charts_drp_data" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/data_report_product-new')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_product-new') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานยอดขายสินค้าใหม่</a>
                                        </li>

                                        <li class="nav-item {{ (request()->is('admin/data_report_full-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_full-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานขายตามหมวดสินค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_historical-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_historical-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>สรุปยอดขาย (รายปี)</a>
                                        </li>
                                        <!-- <li class="nav-item {{ (request()->is('admin/data_report_historical-quarter')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_historical-quarter') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (Quarter)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_historical-month')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_historical-month') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (รายเดือน)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_sale_compare-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_sale_compare-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานสรุปยอดทำเป้า เทียบปี</a>
                                        </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>ยอดขายร้านค้า เทียบปีต่อปี
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="javascript:void(0)">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานรับคืนสินค้า
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/reportYear')) ? 'btn2' : '' }} {{ (request()->is('admin/reportVisitCustomer')) ? 'btn2' : '' }}
                            {{ (request()->is('admin/report_visitcustomer_goal_head')) ? 'btn2' : '' }} {{ (request()->is('admin/reportSaleplan')) ? 'btn2' : '' }}
                            {{ (request()->is('admin/reportTeam')) ? 'btn2' : '' }} {{ (request()->is('admin/reportStore')) ? 'btn2' : '' }}"
                        href="javascript:void(0);" data-toggle="collapse" data-target="#charts_drp">
                                <i class="ion ion-md-stats" style="color: #044067;"></i>
                                <span class="nav-link-text">รายงาน</span>
                            </a>
                            <ul id="charts_drp" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/reportStore')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/admin/reportStore') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานสรุปยอดร้านค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/reportTeam')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/admin/reportTeam') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานลูกทีมที่รับผิดชอบ</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/reportSaleplan')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/admin/reportSaleplan') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานสรุปแผนประจำเดือน</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/report_visitcustomer_goal')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/admin/report_visitcustomer_goal') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานเข้าพบลูกค้าใหม่</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/reportVisitCustomer')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/admin/reportVisitCustomer') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานเข้าพบลูกค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/reportYear')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('/admin/reportYear') }}">
                                                <i class="ion ion-md-stats" style="color: #044067;"></i>รายงานสรุปข้อมูลประจำปี</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                    </ul>
                    <hr class="nav-separator">
                    <div class="nav-header">
                        <span>การจัดการ</span>
                        <span>MG</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <!-- <li class="nav-item {{ (request()->is('admin/news')) ? 'btn2' : '' }}">
                            <a class="nav-link" href="{{ url('admin/news') }}">
                                <i class="ion ion-md-wifi" style="color: #044067;"></i>
                                <span class="nav-link-text">แจ้งข่าวสาร</span>
                            </a>
                        </li>
                        <li class="nav-item {{ (request()->is('admin/pomotion')) ? 'btn2' : '' }}">
                            <a class="nav-link" href="{{ url('admin/pomotion') }}">
                                <i class="ion ion-md-gift" style="color: #044067;"></i>
                                <span class="nav-link-text">โปรโมชั่น</span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/product_new')) ? 'btn2' : '' }} {{ (request()->is('admin/product_property')) ? 'btn2' : '' }}
                                {{ (request()->is('#')) ? 'btn2' : '' }}"
                                href="javascript:void(0);" data-toggle="collapse" data-target="#product">
                                <i class="ion ion-md-cube" style="color: #044067;"></i>
                                <span class="nav-link-text">สินค้า</span>
                            </a>
                            <ul id="product" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/product_new')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/product_new') }}">
                                                <i class="ion ion-md-star" style="color: #044067;"></i>
                                                <span class="nav-link-text">สินค้าใหม่</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/product_property')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/product_property') }}">
                                                <i class="ion ion-md-wallet" style="color: #044067;"></i>
                                                <span class="nav-link-text">คุณสมบัติสินค้า</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('#')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('#') }}">
                                                <i class="ion ion-md-archive" style="color: #044067;"></i>
                                                <span class="nav-link-text">ตรวจสอบเป้าสินค้าใหม่</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/userPermission')) ? 'btn2' : '' }} {{ (request()->is('admin/teamSales')) ? 'btn2' : '' }} {{ (request()->is('admin/checkHistory')) ? 'btn2' : '' }}"
                             href="javascript:void(0);" data-toggle="collapse" data-target="#use">
                                <i class="ion ion-md-options" style="color: #044067;"></i>
                                <span class="nav-link-text">การใช้งาน</span>
                            </a>
                            <ul id="use" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/userPermission')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/userPermission') }}">
                                                <i class="ion ion-md-person" style="color: #044067;"></i>
                                                <span class="nav-link-text">ผู้ใช้งานและสิทธิ์</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/teamSales')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/teamSales') }}">
                                                <i class="ion ion-md-people" style="color: #044067;"></i>
                                                <span class="nav-link-text">กลุ่มและทีม</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/checkHistory')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/checkHistory') }}">
                                                <i class="ion ion-md-pie" style="color: #044067;"></i>
                                                <span class="nav-link-text">ประวัติการใช้งาน</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/master_assignment')) ? 'btn2' : '' }} {{ (request()->is('admin/master_objective_saleplan')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/master_present_saleplan')) ? 'btn2' : '' }} {{ (request()->is('admin/master_tag')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/master_objective_visit')) ? 'btn2' : '' }} {{ (request()->is('admin/master_customer_new')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/master_teamSales')) ? 'btn2' : '' }} {{ (request()->is('admin/master_setting')) ? 'btn2' : '' }}"
                            href="javascript:void(0);" data-toggle="collapse" data-target="#master">
                                <i class="ion ion-md-folder-open" style="color: #044067;"></i>
                                <span class="nav-link-text">มาสเตอร์</span>
                            </a>
                            <ul id="master" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/master_assignment')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_assignment') }}">
                                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                                <span class="nav-link-text">จุดประสงค์ ขอนุมัติ</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/master_objective_saleplan')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_objective_saleplan') }}">
                                                <i class="ion ion-md-book" style="color: #044067;"></i>
                                                <span class="nav-link-text">จุดประสงค์ แผนงาน</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/master_present_saleplan')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_present_saleplan') }}">
                                                <i class="ion ion-md-list" style="color: #044067;"></i>
                                                <span class="nav-link-text">รายการนำเสนอ แผนงาน</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/master_tag')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_tag') }}">
                                                <i class="ion ion-md-bookmark" style="color: #044067;"></i>
                                                <span class="nav-link-text">ป้ายกำกับ (บันทึกโน๊ต)</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/master_objective_visit')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_objective_visit') }}">
                                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                                <span class="nav-link-text">จุดประสงค์เยี่ยมลูกค้า</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/master_customer_new')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_customer_new') }}">
                                                <i class="ion ion-md-create" style="color: #044067;"></i>
                                                <span class="nav-link-text">จุดประสงค์พบลูกค้าใหม่</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/master_teamSales')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_teamSales') }}">
                                                <i class="ion ion-md-people" style="color: #044067;"></i>
                                                <span class="nav-link-text">รายชื่อกลุ่มและทีม</span>
                                            </a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/master_setting')) ? 'btn2' : '' }}">
                                            <a class="nav-link" href="{{ url('admin/master_setting') }}">
                                                <i class="ion ion-md-people" style="color: #044067;"></i>
                                                <span class="nav-link-text">กำหนดค่าต่างๆ</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- <hr class="nav-separator">
                    <div class="nav-header">
                        <span>ข้อมูลที่ใช้ร่วมกัน</span>
                        <span>DATA</span>
                    </div>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('admin/data_name_store')) ? 'btn2' : '' }} {{ (request()->is('admin/data_search_product')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/data_report_product-new')) ? 'btn2' : '' }} {{ (request()->is('admin/data_report_full-year')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/data_report_historical-year')) ? 'btn2' : '' }} {{ (request()->is('admin/data_report_historical-quarter')) ? 'btn2' : '' }}
                                {{ (request()->is('admin/data_report_historical-month')) ? 'btn2' : '' }} {{ (request()->is('admin/data_report_sale_compare-year')) ? 'btn2' : '' }}"
                            href="javascript:void(0);" data-toggle="collapse"
                                data-target="#charts_drp_data">
                                <i class="ion ion-md-book" style="color: #044067;"></i>
                                <span class="nav-link-text">การดูข้อมูล (ใช้ร่วมกัน)</span>
                            </a>
                            <ul id="charts_drp_data" class="nav flex-column collapse collapse-level-1">
                                <li class="nav-item">
                                    <ul class="nav flex-column">
                                        <li class="nav-item {{ (request()->is('admin/data_name_store')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_name_store') }}">
                                                <i class="ion ion-md-home" style="color: #044067;"></i>ตรวจสอบรายชื่อร้านค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_search_product')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_search_product') }}">
                                                <i class="ion ion-md-search"
                                                    style="color: #044067;"></i>ค้นหารายการสินค้า</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_product-new')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_product-new') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานยอดขายสินค้าใหม่</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_full-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_full-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานสรุปยอด (ทั้งปี)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_historical-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_historical-year') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (ทั้งปี)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_historical-quarter')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_historical-quarter') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (Quarter)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_historical-month')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_historical-month') }}">
                                                <i class="ion ion-md-stats"
                                                    style="color: #044067;"></i>รายงานเทียบย้อนหลัง (รายเดือน)</a>
                                        </li>
                                        <li class="nav-item {{ (request()->is('admin/data_report_sale_compare-year')) ? 'btn2' : '' }}">
                                            <a class="nav-link"
                                                href="{{ url('admin/data_report_sale_compare-year') }}">
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
                        <img class="brand-img d-inline-block align-top" src="{{ asset('dist/img/logo-light.png') }}" alt="brand" />
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
   <script src="{{ asset('/public/template/vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('/public/template/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('/public/template/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('/public/template/dist/js/jquery.slimscroll.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('/public/template/dist/js/dropdown-bootstrap-extended.js') }}"></script>

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
    <script src="{{ asset('/public/template/dist/js/feather.min.js') }}"></script>

    <!-- Toggles JavaScript -->
    <script src="{{ asset('/public/template/vendors/jquery-toggles/toggles.min.js') }}"></script>
    <script src="{{ asset('/public/template/dist/js/toggle-data.js') }}"></script>

    <!-- Counter Animation JavaScript -->
    <script src="{{ asset('/public/template/vendors/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('/public/template/vendors/jquery.counterup/jquery.counterup.min.js') }}"></script>

    <!-- Sparkline JavaScript -->
    <script src="{{ asset('/public/template/vendors/jquery.sparkline/dist/jquery.sparkline.min.js') }}"></script>

    <!-- Vector Maps template -->
    <script src="{{ asset('/public/template/vendors/vectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('/public/template/vendors/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('/public/template/dist/js/vectormap-data.js') }}"></script>

    <!-- Owl JavaScript -->
    <script src="{{ asset('/public/template/vendors/owl.carousel/dist/owl.carousel.min.js') }}"></script>

    <!-- Owl Init JavaScript -->
    <script src="{{ asset('/public/template/dist/js/owl-data.js') }}"></script>

    <!-- Select2 JavaScript -->
    <script src="{{ asset('/public/template/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/public/template/dist/js/select2-data.js') }}"></script>

    <!-- Bootstrap Tagsinput JavaScript -->
    {{-- <script src="{{asset('/public/template/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script> --}}

    <!-- Jasny-bootstrap  JavaScript -->
    <script src="{{ asset('/public/template/vendors/jasny-bootstrap/dist/js/jasny-bootstrap.min.js') }}"></script>

    <!-- Data Table JavaScript -->
    <script src="{{ asset('public/template/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('public/template/dist/js/dataTables-data.js') }}"></script>
    <script src="{{ asset('public/template/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>

    <!-- Init JavaScript -->
    <script src="{{ asset('/public/template/dist/js/init.js') }}"></script>
    <script src="{{ asset('/public/template/dist/js/gmap-data.js') }}"></script>

    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js')}}"></script>

    @yield('scripts')

</body>

</html>
