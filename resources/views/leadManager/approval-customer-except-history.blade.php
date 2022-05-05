@extends('layouts.masterLead')

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
            <li class="breadcrumb-item">การขออนุมัติ</li>
            <li class="breadcrumb-item active" aria-current="page">ประวัติการขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>ประวัติการอนุมัติลูกค้าใหม่ (นอกแผน)</h4>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <a href="{{ url('approval-customer-except') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('lead/approval-customer-except-history') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">ประวัติ</span>
                            </a>
                            <hr>
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                            <div class="col-md-6">
                                <h5 class="hk-sec-title">ตารางประวัติการอนุมัติลูกค้าใหม่ (นอกแผน)</h5>
                            </div>
                            <div class="col-md-6">
                                <!-- ------ -->
                                <span class="form-inline pull-right">
                                   <a style="margin-left:5px; margin-right:5px;" id="bt_showdate" class="btn btn-light btn-sm" onclick="showselectdate()">เลือกเดือน</a>
                                   <form action="{{ url('lead/approval-customer-except-history/search') }}" method="POST" enctype="multipart/form-data">
                                       @csrf
                                       {{-- <input type="hidden" name="id" value="{{$id_create}}" /> --}}

                                       <span id="selectdate" style="display:none;">
                                            <input type="month" class="form-control form-control-sm" style="margin-left:10px; margin-right:10px;" name ="selectdateTo" value="" />

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
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>วันที่อนุมัติ</th>
                                            {{-- <th>เรื่อง</th> --}}
                                            <th>พนักงาน</th>
                                            <th>การอนุมัติ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $value)
                                        <?php $chk =  DB::table('customer_shops_saleplan')->join('users', 'customer_shops_saleplan.created_by', '=', 'users.id')
                                        ->where('customer_shops_saleplan.is_monthly_plan', '=', "N")
                                        ->where('customer_shops_saleplan.shop_aprove_status', '=', 2)
                                        ->where('customer_shops_saleplan.created_by', $value->shop_created_by)->select('users.name', 'customer_shops_saleplan.updated_at',
                                        'customer_shops_saleplan.monthly_plan_id')->first(); ?>
                                        @if ($chk)
                                        <tr>
                                            {{-- <input type="hidden" name="monthly_plan_id" value="{{$chk->monthly_plan_id}}"> --}}
                                            <td>{{$key + 1}}</td>
                                            <td>{{Carbon\Carbon::parse($chk->updated_at)->format('Y-m-d')}}</td>
                                            <td>{{$chk->name}}</td>
                                            <td>
                                                <span class="badge badge-soft-success" style="font-size: 12px;">Approve</span></td>
                                            </td>
                                            <td>
                                                <a href="{{url('lead/approval_customer_except_history_detail', $value->shop_created_by)}}" class="btn btn-icon btn-primary btn-link btn_showplan pt-5" value="3">
                                                    <i data-feather="file-text"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <script type="text/javascript">
        function showselectdate(){
             $("#selectdate").css("display", "block");
             $("#bt_showdate").hide();
         }

         function hidetdate(){
             $("#selectdate").css("display", "none");
             $("#bt_showdate").show();
         }
     </script>

<script>
    $(document).on('click', '.btn_showplan', function(){
        let plan_id = $(this).val();
        //alert(goo);
        $('#Modalsaleplan').modal("show");
    });
</script>

@endsection
