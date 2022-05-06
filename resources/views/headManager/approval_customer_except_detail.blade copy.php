@extends('layouts.masterHead')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active">การอนุมัติลูกค้าใหม่ (นอกแผน)</li>
            <li class="breadcrumb-item active" aria-current="page">รายการข้อมูลการอนุมัติลูกค้าใหม่ (นอกแผน)</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        @if (session('error'))
        <div class="alert alert-inv alert-inv-warning alert-wth-icon alert-dismissible fade show" role="alert">
            <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i>
            </span> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>รายการข้อมูลการอนุมัติลูกค้าใหม่ (นอกแผน)</h4>
            </div>
            <div class="d-flex">
                <a href="{{ url('head/approval-customer-except')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
            {{-- <div class="d-flex">
                <form action="{{ url('lead/approval_confirm_detail') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn_purple btn-violet btn-sm btn-rounded px-3" name="approve" value="approve">อนุมัติ</button>

                <button type="submit" class="btn btn_purple btn-danger btn-sm btn-rounded px-3 ml-5" name="failed" value="failed">ไม่อนุมัติ</button>
            </div> --}}
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                            <div class="col-md-12">
                                <h5 class="hk-sec-title">ตารางรายการข้อมูลการอนุมัติลูกค้าใหม่ (นอกแผน)</h5>
                            </div>
                            <div class="col-md-9">

                            </div>
                        </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อร้าน</th>
                                            <th>อำเภอ,จังหวัด</th>
                                            <th>การอนุมัติ</th>
                                            <th>ความคิดเห็น</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customer_except as $key => $value)

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
                                            <td>{{ $value->PROVINCE_NAME }}</td>
                                            <td>
                                                @if ($value->shop_aprove_status == 1)
                                                <span class="badge badge-soft-warning mt-15 mr-10" style="font-size: 12px;">Pending</span>
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
                                            <td>
                                                @if ($value->shop_aprove_status == 1)
                                                    <a href="{{ url('head/comment_customer_new', [$value->custid, $value->id, $value->monthly_plan_id]) }}" class="btn btn-icon btn-info mr-10">
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                            <i data-feather="message-square"></i>
                                                        </h4>
                                                    </a>
                                                @else
                                                    <button class="btn btn-icon btn-info mr-10" disabled>
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                            <i data-feather="message-square"></i>
                                                        </h4>
                                                    </button>
                                                @endif
                                                <button class="btn_showshop btn btn-icon btn-info mr-10" value="{{ $value->custid, }}">
                                                    <h4 class="btn-icon-wrap" style="color: white;">
                                                        <i data-feather="file-text"></i>
                                                    </h4>
                                                </button>
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
        </div>
    {{-- </form> --}}
        <!-- /Row -->
    </div>
    <!-- /Container -->

<!-- Modal Show Customer Shop -->
<div class="modal fade" id="Modalshop" tabindex="-1" role="dialog" aria-labelledby="Modalshop" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="get_id">
                        <div class="form-group">
                            <label for="firstName">ชื่อร้านค้า : </label>
                            <span id="span_shop_name"></span>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">ที่อยู่ : </label>
                                <span id="span_shop_address"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">ชื่อผู้ติดต่อ : </label>
                                <span id="span_customer_contact_name"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="username">เบอร์โทรติดต่อ : </label>
                                <span id="span_customer_contact_phone"></span>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>

                </div>
            </div>
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

@endsection('content')

@section('scripts')

<script>
    $(document).on('click', '.btn_showplan', function(){
        let plan_id = $(this).val();
        //alert(goo);
        $('#Modalsaleplan').modal("show");
    });

    $(document).on('click', '.btn_showshop', function(){
        let cusid = $(this).val();
        console.log(cusid);
        $.ajax({
            method: 'GET',
            url: '{{ url("/fetch_customer_shops_byid") }}/'+cusid,
            datatype: 'json',
            success: function(response) {
                console.log(response);
                if(response.status == 200){
                    let address = response.customer_shops.shop_address +" "+ response.district_name +" "+
                    response.amphur_name +" "+ response.province_name;
                    $('#span_shop_name').text(response.customer_shops.shop_name);
                    $('#span_shop_address').text(address);
                    $('#span_customer_contact_name').text(response.customer_contacts.customer_contact_name);
                    $('#span_customer_contact_phone').text(response.customer_contacts.customer_contact_phone);
                    $('#Modalshop').modal("show");
                }
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


<script type="text/javascript">
    function chkAll(checkbox) {

        var cboxes = document.getElementsByName('checkapprove');
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
    document.getElementById('btn_approve').onclick = function() {
        var markedCheckbox = document.getElementsByName('checkapprove');
        var saleplan_id_p = "";

        for (var checkbox of markedCheckbox) {
            if (checkbox.checked) {
                if (checkbox.value != "") {
                    saleplan_id_p += checkbox.value + ' ,';
                }
            }
        }
        if (saleplan_id_p != "") {
            $('#Modalapprove').modal('show');
            $('#saleplan_id').val(saleplan_id_p);
        } else {
            alert('กรุณาเลือกรายการด้วยค่ะ');
        }
    }

    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }

    
</script>



@endsection

