@extends('layouts.masterAdmin')

@section('content')



    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item">ปิด Sale Plan</li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียด Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i
                            class="ion ion-md-analytics"></i></span>รายละเอียด Sale Plan</h4>
            </div>
            <div class="d-flex">
                <a href="{{ url('admin/approvalsaleplan')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <h5 class="hk-sec-title mb-10">รายงานสรุป Sale Plan ของ {{ $sale_name->name }}
                                ประจำเดือน <?php echo thaidate('F Y', $mon_plan->month_date); ?>
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">

                                <table class="table table-sm table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ร้านค้า</th>
                                            <th style="width:15%;">อำเภอ,จังหวัด</th>
                                            <th>วัตถุประสงค์</th>
                                            <th style="width:33%;">รายการนำเสนอ</th>
                                            <th style="width:9%;">จำนวนบิล</th>
                                            <th style="width:10%;">มูลค่าบิล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_bills = 0;
                                            $total_sales = 0;
                                            $total_pglist = 0;
                                        @endphp
                                        @foreach ($list_saleplan as $key => $value)
                                            @php
                                                $sum_bills = 0;
                                                $sum_sales = 0;

                                                $customer_name = "";
                                                $customer_address = "";
                                                if(isset($customer_api)){
                                                    foreach($customer_api as $key_api => $value_api){
                                                        if($customer_api[$key_api]['identify'] == $value->customer_shop_id){
                                                            if($customer_name != $customer_api[$key_api]['shop_name']){
                                                                $customer_name = $customer_api[$key_api]['shop_name'];
                                                                $customer_address = $customer_api[$key_api]['shop_address'];
                                                            }
                                                        }
                                                    }
                                                }
                                            @endphp

                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $customer_name }}</td>
                                                <td>{{ $customer_address }}</td>
                                                <td>
                                                    @php
                                                        $sale_plans_objective = DB::table('master_objective_saleplans')
                                                            ->where('id', $value->sale_plans_objective)
                                                            ->first();
                                                    @endphp
                                                    {{  $sale_plans_objective->masobj_title }}
                                                </td>
                                                <td>
                                                    @php
                                                        $listpresent = explode(',',$value->sale_plans_tags);
                                                        foreach($listpresent as $key_list => $value_list ){
                                                            $pdlist_name = "";
                                                            if(isset($pdglists_api)){
                                                                foreach($pdglists_api as $key_api => $value_api){
                                                                    if($value_api['identify'] == $value_list){
                                                                        $pdlist_name = $pdglists_api[$key_api]['name'];
                                                                    }
                                                                }
                                                            }
                                                            echo $pdlist_name."<br>";
                                                            $total_pglist += 1;
                                                        }
                                                    @endphp
                                                </td>
                                                <td style="text-align:center;">
                                                    @php
                                                        $listpresent = explode(',',$value->sale_plans_tags);
                                                        foreach($listpresent as $key_list => $value_list ){
                                                            $bills = 0;
                                                            if(isset($saleplan_api)){
                                                                foreach($saleplan_api as $key_api => $value_api){
                                                                    if($saleplan_api[$key_api]['pdlist_id'] == $value_list){
                                                                        if($saleplan_api[$key_api]['customer_id'] == $value->customer_shop_id){
                                                                            if($saleplan_api[$key_api]['pdlist_name'] != ""){
                                                                                $bills= $saleplan_api[$key_api]['bills'];
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }


                                                            echo $bills."<br>";
                                                            $sum_bills += $bills;
                                                        }
                                                    @endphp
                                                </td>
                                                <td style="text-align:right;">
                                                    @php
                                                        $listpresent = explode(',',$value->sale_plans_tags);
                                                        foreach($listpresent as $key_list => $value_list ){
                                                            $sales = 0;
                                                            if(isset($saleplan_api)){
                                                                foreach($saleplan_api as $key_api => $value_api){
                                                                    if($saleplan_api[$key_api]['pdlist_id'] == $value_list){
                                                                        if($saleplan_api[$key_api]['customer_id'] == $value->customer_shop_id){
                                                                            if($saleplan_api[$key_api]['pdlist_name'] != ""){
                                                                                $sales= $saleplan_api[$key_api]['sales'];
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }

                                                            echo number_format($sales,2)."<br>";
                                                            $sum_sales += $sales;

                                                    @endphp
                                                </td>
                                            </tr>
                                            <tr class="bg-teal text-white">
                                                <td colspan="5">รวมร้านค้า [{{ $value->customer_shop_id }}] {{ $customer_name }}</td>
                                                <td style="text-align:center;">{{ $sum_bills }}</td>
                                                <td style="text-align:right;">{{ number_format($sum_sales,2) }}</td>
                                            </tr>
                                            @php
                                                $total_bills += $sum_bills;
                                                $total_sales += $sum_sales;
                                            @endphp
                                        @endforeach
                                            <tr>
                                                <td colspan="5"><strong>รวมทั้งสิ้น</strong></td>
                                                <td style="text-align:center;"><strong>{{ number_format($total_bills) }}</strong></td>
                                                <td style="text-align:right;"><strong>{{ number_format($total_sales,2) }}</strong></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->

        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <h5 class="hk-sec-title mb-10">สรุปปิดแผน</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="text-align:center;">
                            <div class="col-12">
                                จำนวนแผน (นำเสนอสินค้า ) ทั้งสิ้น
                            </div>
                            <div class="col-12 bg-indigo text-white py-5">
                                {{ $total_pglist }}
                            </div>
                        </div>
                        <div class="col-md-3" style="text-align:center;">
                            <div class="col-12">
                                ปิดการขายได้ (แผน)
                            </div>
                            <div class="col-12 bg-success text-white py-5">
                                {{ number_format($total_bills) }}
                            </div>
                        </div>
                        <div class="col-md-3" style="text-align:center;">
                            <div class="col-12">
                                จำนวนบิลรวม
                            </div>
                            <div class="col-12 bg-indigo text-white py-5">
                                {{ number_format($total_bills) }}
                            </div>
                        </div>
                        <div class="col-md-3" style="text-align:center;">
                            <div class="col-12">
                                มูลค่ายอดขายรวม
                            </div>
                            <div class="col-12 bg-success text-white py-5">
                                {{ number_format($total_sales,2) }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="col-xl-12">
            <div style="text-align:center;">
                <form action="{{ url('admin/approvalsaleplan_close') }}" method="post">
                    @csrf
                    <input name="monthly_plans_id" id="monthly_plans_id" value="{{ $mon_plan->id }}" type="hidden" class="form-control">
                    <input type="hidden" name="saleplan_amount" value="{{ $total_pglist }}">
                    <input type="hidden" name="close_sale" value="{{ $total_bills }}">
                    <input type="hidden" name="bill_amount" value="{{ $total_bills }}">
                    <input type="hidden" name="total_sale" value="{{ $total_sales }}">
                    @if ($mon_plan->status_approve != 4)
                    <button type="submit" class="btn btn-danger btn-sm px-3 mr-10" style="width:20%; height:50px;">ปิดแผน</button>
                    @endif
                </form>
            </div>
            @if ($mon_plan->status_approve == 4)
                <div class="alert alert-inv alert-inv-secondary" role="alert" style="text-align:center;">ปิดแผนแล้ว</div>
            @endif
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

<script type="text/javascript">
    function chkAll_customer(checkbox) {

        var cboxes = document.getElementsByName('checkapprove_cust[]');
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

    <script>
        $("#form_approval_saleplan").on("submit", function(e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('lead/approval_saleplan_confirm') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Your work has been saved',
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // })
                    $("#exampleModalLarge02").modal('hide');
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });
    </script>

@section('scripts')

@endsection('content')



@endsection('scripts')
