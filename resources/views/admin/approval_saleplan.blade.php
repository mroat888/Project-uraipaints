@extends('layouts.masterAdmin')

@section('content')

@php

    $date = date('m-d-Y');

    $date1 = str_replace('-', '/', $date);

    $yesterday = date('Y-m-d',strtotime($date1 . "-1 days"));



    $date1 = str_replace('-', '/', $date);

    $yesterday2 = date('Y-m-d',strtotime($date1 . "-2 days"));

@endphp
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ปิด Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

     <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

         <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-analytics"></i></span>ปิด Sale Plan</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
                <div class="col-xl-12">
                    <section class="hk-sec-wrapper">
                        <div class="row mb-2">
                            <div class="col-sm-12 col-md-6">
                                @php
                                    if(isset($search_month) && isset($search_year)){
                                        $search_date = $search_year.'-'.$search_month;
                                        $search_date = thaidate('F Y', $search_date);
                                    }else{
                                        $search_date = "";
                                    }
                                @endphp
                                <h5 class="hk-sec-title">รายการแผนประจำเดือน {{ $search_date }}</h5>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <!-- ------ -->
                                <span class="form-inline pull-right">
                                    <button style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เงื่อนไขค้นหา</button>
                                    <form action="{{ url('admin/approvalsaleplan/search') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <span id="selectdate" style="display:none;">
                                            <select name="sel_team" class="form-select form-control form-control-sm" aria-label="Default select example">
                                                <option value="0" selected>---เลือกทีม--</option>
                                                @foreach($teams as $team)
                                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" id="selectdateTo" name ="selectdateTo" value="<?= date('Y-m-d'); ?>"/>

                                            <button type="submit" style="margin-left:5px; margin-right:5px;" class="btn btn-success btn-sm" id="submit_request" onclick="hidetdate()">ค้นหา</button>
                                        </span>
                                    </form>
                                    </span>
                                    <!-- ------ -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm">
                                <div class="table-responsive-sm">
                                    <table id="datable_1" class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="text-align:left;">ผู้แทนขาย</th>
                                                <th>Sale Plan<br>(นำเสนอสินค้า)</th>
                                                <th>Sale Plan<br>(ลูกค้าใหม่)</th>
                                                <th>รวมงาน</th>
                                                <th>ปิดการขายได้</th>
                                                <th>มูลค่า</th>
                                                <th>ปิดกาาขาย<br>ไม่ได้</th>
                                                <th>จำนวนลูกค้าใหม่</th>
                                                <th>การอนุมัติ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monthly_plan as $key => $value)
                                                @php
                                                    $sale_plans = DB::table('sale_plans')
                                                        ->where('monthly_plan_id',$value->id)
                                                        ->get();
                                                    $sale_plan_amount = $sale_plans->count();

                                                    $customer_shops_saleplan = DB::table('customer_shops_saleplan')
                                                        ->where('monthly_plan_id', $value->id)
                                                        ->get();
                                                    $cust_new_amount = $customer_shops_saleplan->count();

                                                    $total_plan = $sale_plan_amount + $cust_new_amount;

                                                    //--  API ------//
                                                    $user_api = DB::table('users')->where('id',$value->created_by)->first();
                                                    list($year,$month,$day) = explode('-', $value->month_date);
                                                    $month = $month + 0;

                                                    $path_search = "reports/sellers/".$user_api->api_identify."/closesaleplans?years=".$year."&months=".$month;
                                                    $response = Http::withToken($api_token)->get(env("API_LINK").env("API_PATH_VER")."/".$path_search);
                                                    $res_api = $response->json();

                                                    $bills = 0;
                                                    $sales = 0;
                                                    if($res_api['code'] == 200){
                                                        $saleplan_api = $res_api['data'];

                                                        foreach($saleplan_api as $key_api => $value_api){
                                                            $bills += $saleplan_api[$key_api]['bills'];
                                                            $sales += $saleplan_api[$key_api]['sales'];
                                                        }
                                                    }

                                                    $total_pglistpresent = 0; // เก็บจำนวนสินค้าค้านำเสนอ
                                                    foreach($sale_plans as $pglist_value){
                                                        $listpresent = explode(',',$pglist_value->sale_plans_tags);
                                                        foreach($listpresent as $value_list ){
                                                            $total_pglistpresent += 1;
                                                        }
                                                    }

                                                    $not_bills = $total_pglistpresent - $bills;

                                                @endphp
                                                <tr style="text-align:center;">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td style="text-align:left;">{{ $value->name }}</td>
                                                    <td>{{ $sale_plan_amount }}</td>
                                                    <td>{{ $cust_new_amount }}</td>
                                                    <td>{{ $total_plan }}</td>
                                                    <td>{{ $bills }}</td>
                                                    <td>{{ number_format($sales,2) }}</td>
                                                    <td>{{ number_format($not_bills) }}</td>
                                                    <td> ดึงจาก Admin</td>
                                                    <td>
                                                        @if($value->status_approve == 1)
                                                            <span class="badge badge-soft-warning" style="font-size: 12px;">
                                                                Pending
                                                            </span>
                                                        @elseif($value->status_approve == 2)
                                                            <span class="badge badge-soft-success"style="font-size: 12px;">
                                                                Approve
                                                            </span>
                                                        @elseif($value->status_approve == 3)
                                                            <span class="badge badge-soft-purple" style="font-size: 12px;">
                                                                Reject
                                                            </span>
                                                        @elseif($value->status_approve == 4)
                                                            <span class="badge badge-soft-info"style="font-size: 12px;">
                                                                Close
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('admin/approvalsaleplan_close', $value->id) }}" type="button" class="btn btn-icon btn-purple pt-5">
                                                            <i data-feather="check-circle"></i>
                                                        </a>
                                                        <a href="{{ url('admin/approvalsaleplan_detail', $value->id) }}" type="button" class="btn btn-icon btn-primary pt-5">
                                                            <i data-feather="file-text"></i>
                                                        </a>
                                                        <button id="btn_saleplan_restrospective" type="button" class="btn btn-icon btn-warning ml-2" value="{{ $value->id }}">
                                                            <i data-feather="refresh-ccw"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <!-- /Row -->
    </div>

    <!-- Modal Delete Saleplan -->
    <div class="modal fade" id="ModalSaleplanRestorespective" tabindex="-1" role="dialog" aria-labelledby="ModalSaleplanRestorespective"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_saleplan_restorespective" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการส่งข้อมูล Sale Plan กลับใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการส่งข้อมูล Sale Plan กลับใช่หรือไม่ ?</h3>
                        <input class="form-control" id="restros_id" name="restros_id" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        function chkAll(checkbox) {

            var cboxes = document.getElementsByName('checkapprove[]');
            var len = cboxes.length;

            if (checkbox.checked == true) {
                for (var i = 0; i < len; i++) {
                    cboxes[i].checked = true;
                }
            } else {
                for (var i = 0; i < len; i++) {
                    cboxes[i].checked = false;
                }
            }
        }
    </script>

@endsection

@section('scripts')


<script>
    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }

    $(document).on('click', '#btn_saleplan_restrospective', function() {
            let restros_id = $(this).val();
            $('#restros_id').val(restros_id);
            $('#ModalSaleplanRestorespective').modal('show');
        });

        $("#from_saleplan_restorespective").on("submit", function(e) {
            e.preventDefault();
            //var formData = $(this).serialize();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/retrospective') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'เรียบร้อย!',
                        text: "ส่งข้อมูลกลับเรียบร้อยแล้วค่ะ",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalSaleplanRestorespective').modal('hide');
                    $('#shop_status_name_lead').text('ส่งข้อมูล Sale Plan กลับเรียบร้อย')
                    $('#btn_saleplan_restrospective').prop('disabled', true);
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });
</script>

<script>
    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function() {
            $(".success").fadeOut();
        }, 1000);
    }
</script>

<script>
    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>

@endsection('scripts')
