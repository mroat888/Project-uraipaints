@extends('layouts.masterLead')

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
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i
                            class="ion ion-md-analytics"></i></span>รายละเอียด Sale Plan</h4>
            </div>
            <form action="{{ url('lead/approval_saleplan_confirm') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="d-flex">
                    <button type="submit" class="btn btn_purple btn-violet btn-sm btn-rounded px-3" name="approve" value="approve">อนุมัติ</button>

                    <button type="submit" class="btn btn_purple btn-danger btn-sm btn-rounded px-3 ml-5" name="failed" value="failed">ไม่อนุมัติ</button>
                </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title mb-10">ตาราง Sale Plan</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">

                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customCheck4" onclick="chkAll(this);" name="CheckAll" value="Y">
                                                    <label class="custom-control-label"
                                                        for="customCheck4">ทั้งหมด</label>
                                                </div>
                                            </th>
                                            <th>#</th>
                                            <th>เรื่อง</th>
                                            <th>ลูกค้า</th>
                                            {{-- <th>การอนุมัติ</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list_saleplan as $key => $value)
                                            <?php
                                            // $date = Carbon\Carbon::parse($value->sale_plans_date)->format('Y-m');
                                            // $dateNow = Carbon\Carbon::today()->format('Y-m');
                                            // if ($date == $dateNow && $value->sale_plans_status == 1) {
                                            ?>
                                            <tr>

                                                <td>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkapprove"
                                                            name="checkapprove[]" id="customCheck{{$key + 1}}" value="{{$value->id}}">
                                                        <label class="custom-control-label" for="customCheck{{$key + 1}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->sale_plans_title }}</td>
                                                {{-- <td>{{$value->customer_shop_id}}</td> --}}
                                                <td>
                                                    @foreach($customer_api as $key_api => $value_api)
                                                                @if($customer_api[$key_api]['id'] == $value->customer_shop_id)
                                                                    {{ $customer_api[$key_api]['shop_name'] }}
                                                                @endif
                                                            @endforeach
                                                </td>
                                                {{-- <td>{{ $value->name }}</td> --}}
                                                {{-- <td><span class="badge badge-soft-warning"
                                                        style="font-size: 12px;">Pending</span></td> --}}
                                                <td>
                                                    <a href="{{ url('comment_saleplan', [$value->id, $value->created_by]) }}" class="btn btn-icon btn-info mr-10">
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                            <i data-feather="message-square"></i>
                                                        </h4>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            // }
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div>
                            <h5 class="hk-sec-title">ตารางพบลูกค้าใหม่</h5>
                            {{-- <h6 class="hk-sec-title mb-10" style="font-weight: bold;">ตารางพบลูกค้าใหม่</h6> --}}
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
                                    <table id="datable_1_2" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck5" onclick="chkAll_customer(this);" name="CheckAll_cust" value="Y">
                                                        <label class="custom-control-label" for="customCheck5">ทั้งหมด</label>
                                                    </div>
                                                </th>
                                                <th>#</th>
                                                <th>ชื่อร้าน</th>
                                                <th>อำเภอ,จังหวัด</th>
                                                <th>สถานะ</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_new as $key => $value)
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox checkbox-info">
                                                            <input type="checkbox" class="custom-control-input checkapprove_cust"
                                                                name="checkapprove_cust[]" id="customNewCheck{{$key + 1}}" value="{{$value->id}}">
                                                            <label class="custom-control-label" for="customNewCheck{{$key + 1}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $value->shop_name }}</td>
                                                    <td>{{ $value->PROVINCE_NAME }}</td>
                                                    <td>
                                                        <span class="badge badge-soft-indigo mt-15 mr-10"
                                                            style="font-size: 12px;">ลูกค้าใหม่</span>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <a href="{{ url('comment_customer_new', [$value->id, $value->created_by]) }}" class="btn btn-icon btn-info mr-10">
                                                            <h4 class="btn-icon-wrap" style="color: white;">
                                                                <i data-feather="message-square"></i>
                                                            </h4>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                    //  }
                                                ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                </div>
                            </div>
                        </div>
                </section>
            </div>

            <div class="col-md-12">
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
                                                <th>ที่อยู่</th>
                                                <th>วันสำคัญ</th>
                                                {{-- <th class="text-center">Action</th> --}}
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
                                                {{-- <td>
                                                    <div class="button-list">
                                                        <a href="{{url('delete_visit')}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-trash"></i></h4></a>
                                                    </div>
                                                </td> --}}
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
