@extends('layouts.masterHead')

@section('content')



    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item">อนุมัติ Sale Plan</li>
            <li class="breadcrumb-item active" aria-current="page">รายละเอียด Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
                <!-- Title -->
                <div class="hk-pg-header mb-10">
                    <div class="topichead-bgred"><i data-feather="file-text"></i> รายละเอียดแผนประจำเดือน <?php echo thaidate('F Y', $monthly_plans->month_date); ?> ({{ $sale_name->name }})</div>
                    <div class="content-right d-flex">
                        <a href="{{ url('head/approvalsaleplan')}}" type="button" class="btn btn-secondary btn-rounded"> ย้อนกลับ </a>
                    </div>
                </div>
                <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div class="topichead-bggreen">Sale Plan (นำเสนอสินค้า)</div>
                </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm table-color">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>วัตถุประสงค์</th>
                                            <th>ลูกค้า</th>
                                            <th>อำเภอ,จังหวัด</th>
                                            <th>จำนวนรายการนำเสนอ</th>
                                            <th>การอนุมัติ</th>
                                            <th>ความคิดเห็น</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($list_saleplan as $key => $value)
                                        @php
                                            if($value->sale_plans_status != 1){
                                                $bg_approve = "background-color: rgb(219, 219, 219);";
                                            }else{
                                                $bg_approve = "";
                                            }
                                        @endphp
                                        <tr style="{{ $bg_approve }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value->masobj_title }}</td>
                                            <td>
                                                @foreach($customer_api as $key_api => $value_api)
                                                    @if($customer_api[$key_api]['id'] == $value->customer_shop_id)
                                                        {{ $customer_api[$key_api]['shop_name'] }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($customer_api as $key_api => $value_api)
                                                    @if($customer_api[$key_api]['id'] == $value->customer_shop_id)
                                                        {{ $customer_api[$key_api]['shop_address'] }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @php
                                                    $tags = explode(",", $value->sale_plans_tags);
                                                @endphp
                                                {{ count($tags) }}
                                            </td>
                                            <td>
                                                @if ($value->sale_plans_status == 1)
                                                <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>

                                                @elseif ($value->sale_plans_status == 2)
                                                <span class="badge badge-soft-success" style="font-size: 12px;">Approve</span>

                                                @elseif ($value->sale_plans_status == 3)
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">Reject</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $sale_plan_comments = DB::table('sale_plan_comments')
                                                        ->where('saleplan_id',$value->id)
                                                        ->where('created_by', Auth::user()->id)
                                                        ->first();
                                                @endphp
                                                @if(!is_null($sale_plan_comments))
                                                    <span class="badge badge-soft-purple" style="font-size: 12px;">Comment</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('head/comment_saleplan', [$value->id, $value->monthly_plan_id]) }}" class="btn btn-icon mr-10" style="background-color: rgb(2, 119, 144);">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i data-feather="message-square"></i>
                                                    </h4>
                                                </a>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div class="topichead-blue">Sale Plan (เป้าหมายลูกค้าใหม่)</div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="table-responsive-sm table-color">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อร้าน</th>
                                                <th>อำเภอ,จังหวัด</th>
                                                <th>วัตถุประสงค์</th>
                                                <th>การอนุมัติ</th>
                                                <th>ความคิดเห็น</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_new as $key => $value)
                                            @php
                                                if($value->shop_aprove_status != 1){
                                                    $bg_approve = "background-color: rgb(219, 219, 219);";
                                                }else{
                                                    $bg_approve = "";
                                                }
                                            @endphp
                                            <tr style="{{ $bg_approve }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->shop_name }}</td>
                                                <td>{{$value->AMPHUR_NAME}}, {{ $value->PROVINCE_NAME }}</td>
                                                <td>{{ $value->cust_name }}</td>
                                                <td>
                                                    @if ($value->shop_aprove_status == 1)
                                                    <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>

                                                    @elseif ($value->shop_aprove_status == 2)
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">Approve</span></td>

                                                    @elseif ($value->shop_aprove_status == 3)
                                                    <span class="badge badge-soft-danger" style="font-size: 12px;">Reject</span></td>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $customer_shop_comments = DB::table('customer_shop_comments')
                                                            ->where('customer_shops_saleplan_id',$value->id)
                                                            ->where('created_by', Auth::user()->id)
                                                            ->first();
                                                    @endphp
                                                    @if(!is_null($customer_shop_comments))
                                                        <span class="badge badge-soft-purple" style="font-size: 12px;">Comment</span>
                                                    @endif
                                                </td>
                                                <td style="text-align:center">
                                                    <a href="{{ url('head/comment_customer_new', [$value->custid, $value->id, $value->monthly_plan_id]) }}" class="btn btn-icon mr-10" style="background-color: rgb(2, 119, 144);">
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                            <i data-feather="message-square"></i>
                                                        </h4>
                                                    </a>
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

            {{-- <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div>
                            <h5 class="hk-sec-title mb-10">เยี่ยมลูกค้า</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10 mt-10">
                                    <div>
                                    </div>
                                </div>
                                <div class="table-responsive col-md-12">
                                    <table id="datable_1_3" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อร้าน</th>
                                                <th>อำเภอ,จังหวัด</th>
                                                <th>วันสำคัญ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @foreach ($customer_visit_api as $key => $value)

                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{$customer_visit_api[$key]['shop_name']}}</td>
                                                <td>{{$customer_visit_api[$key]['shop_address']}}</td>
                                                <td>-</td>
                                            </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </section>
            </div> --}}

        </div>
        <!-- /Row -->
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
