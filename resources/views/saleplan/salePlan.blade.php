@extends('layouts.master')

@section('content')

    @php

    $date = date('m-d-Y');

    $date1 = str_replace('-', '/', $date);

    $yesterday = date('Y-m-d', strtotime($date1 . '-1 days'));

    $date1 = str_replace('-', '/', $date);

    $yesterday2 = date('Y-m-d', strtotime($date1 . '-2 days'));

    @endphp
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sale Plan</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-calendar"></i></span>Sale Plan
                </h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn_green btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal"
                    data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                <a href="{{url('create_saleplan')}}" type="button" class="btn btn_purple btn-violet btn-sm btn-rounded px-3" id="btn_approve">ขออนุมัติ</a>
            </div>

        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตาราง Sale Plan</h5>
                        </div>
                        <div class="col-sm-12 col-md-9">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    {{-- <div class="box_search d-flex">
                                    <span class="txt_search">Search:</span>
                                        <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                                    </div> --}}
                                </div>
                                <div class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck4" onclick="chkAll(this);" name="customCheck4">
                                                        <label class="custom-control-label"
                                                            for="customCheck4">ทั้งหมด</label>
                                                    </div>
                                                </th>
                                                <th>#</th>
                                                <th>เรื่อง</th>
                                                {{-- <th>วันที่</th> --}}
                                                <th>ลูกค้า</th>
                                                <th>การอนุมัติ</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_saleplan as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkapprove"
                                                            name="checkapprove" id="customCheck41" value="1">
                                                        <label class="custom-control-label" for="customCheck41"></label>
                                                    </div>
                                                </td>
                                                <td>{{$key + 1}}</td>
                                                <td><span class="topic_purple">{{$value->sale_plans_title}}</span></td>
                                                {{-- <td>11/10/2021</td> --}}
                                                <td>{{$value->customer_shop_id}}</td>
                                                <td>
                                                    @if ($value->sale_plans_status == 0)
                                                    <span class="badge badge-soft-secondary" style="font-size: 12px;">Darf</span>
                                                    @elseif ($value->sale_plans_status == 1)
                                                    <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span>
                                                    @else
                                                    <span class="badge badge-soft-success" style="font-size: 12px;">Approval</span>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    <div class="button-list">
                                                        {{-- <button class="btn btn-icon btn-primary" data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-in"></i></span></button>
                                                        <button class="btn btn-icon btn-pumpkin" data-toggle="modal" data-target="#Modalcheckin" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-out"></i></span></button>
                                                        <button class="btn btn-icon btn-neon" data-toggle="modal" data-target="#Modalvisit" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="book"></i></span></button> --}}

                                                        <button onclick="edit_modal({{ $value->id }})" class="btn btn-icon btn-warning mr-10"
                                                            data-toggle="modal" data-target="#saleplanEdit">
                                                            <span class="btn-icon-wrap"><i data-feather="edit"
                                                                ></i></span></button>
                                                                {{-- <a href="{{url('edit_saleplan', $value->id)}}">XX</a> --}}
                                                        <a href="{{url('delete_saleplan', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"
                                                                ></i></span></a>
                                                    </div>
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
        <!-- /Row -->
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01"
        aria-hidden="true">
        @include('saleplan.salePlanForm')
    </div>

     <!-- Modal Edit -->
     <div class="modal fade" id="saleplanEdit" tabindex="-1" role="dialog" aria-labelledby="saleplanEdit"
     aria-hidden="true">
     @include('saleplan.salePlanForm_edit')
 </div>

    <!-- Modal -->
    <div class="modal fade" id="Modalvisit" tabindex="-1" role="dialog" aria-labelledby="Modalvisit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">สรุปผลการเข้าพบ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="address" cols="30" rows="5" placeholder="" value=""
                                type="text"> </textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">สรุปผลลัพธ์</label>
                                <select class="form-control custom-select">
                                    <option selected>-- กรุณาเลือก --</option>
                                    <option value="1">ไม่สนใจ</option>
                                    <option value="2">รอตัดสินใจ</option>
                                    <option value="3">สนใจ/ตกลง</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Check Approve -->
    <div class="modal fade" id="Modalapprove" tabindex="-1" role="dialog" aria-labelledby="Modalapprove"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ส่งคำขออนุมัติ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align:center;">
                    <h3>ยืนยันส่งคำขออนุมัติ ใช่หรือไม่ ?</h3>
                    <form action="#">
                        <input class="form-control" id="saleplan_id" type="hidden" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>



    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> --}}

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
