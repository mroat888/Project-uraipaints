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
            <form name="form1" class="form1" id="form1" action="{{ url('lead/approval_saleplan_confirm') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="hdnCount" value="{{ $list_saleplan->count() }}">
                <div class="d-flex">
                    {{-- <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
                    <button type="submit" class="btn btn-teal btn-sm btn-rounded px-3" id="ss">อนุมัติ</button>
                </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตารางรายละเอียด Sale Plan</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive-sm">

                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id='checkall' /> Select All

                                                {{-- <div class="custom-control custom-checkbox checkbox-info">
                                                <input type="checkbox" class="custom-control-input" name="CheckAll"
                                                    id="CheckAll" onclick="chkAll(this);">
                                                <label class="custom-control-label"
                                                    for="CheckAll">ทั้งหมด</label>
                                            </div> --}}
                                            </th>
                                            <th>#</th>
                                            <th>วันที่</th>
                                            <th>พนักงานขาย</th>
                                            <th>การอนุมัติ</th>
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
                                                    {{-- <input class="checkbox" name="emailid[]" id="chkbox{{ $key + 1 }}" type="checkbox" value="{{ $key + 1 }}" /> --}}
                                                    {{-- <label class="custom-control-label" for="chkbox{{$key + 1}}"></label> --}}

                                                    <div class="custom-control custom-checkbox checkbox-info">
                                                        <input type="checkbox" class="custom-control-input checkbox"
                                                            name="checkapprove[]" id="checkapprove{{$key + 1}}" value="{{ $value->id }}">
                                                        <label class="custom-control-label" for="checkapprove{{$key + 1}}"></label>
                                                    </div>
                                                </td>

                                                </form>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->sale_plans_date }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td><span class="badge badge-soft-warning"
                                                        style="font-size: 12px;">Pending</span></td>
                                                <td>
                                                    <button class="btn btn-icon btn-primary mr-10"
                                                        onclick="edit_modal({{ $value->id }})" data-toggle="modal"
                                                        data-target="#exampleModalLarge02">
                                                        <h4 class="btn-icon-wrap" style="color: white;">
                                                            <i data-feather="message-square"></i>
                                                        </h4>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php
                                            // }
                                            ?>
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
    <div class="modal fade" id="exampleModalLarge02" tabindex="-1" role="dialog">
        @include('leadManager.comment_saleplan')
    </div>

    <script type='text/javascript'>
        $(document).ready(function(){
          // Check or Uncheck All checkboxes
          $("#checkall").change(function(){
            var checked = $(this).is(':checked');
            if(checked){
              $(".checkbox").each(function(){
                $(this).prop("checked",true);
              });
            }else{
              $(".checkbox").each(function(){
                $(this).prop("checked",false);
              });
            }
          });

         // Changing state of CheckAll checkbox
         $(".checkbox").click(function(){

           if($(".checkbox").length == $(".checkbox:checked").length) {
             $("#checkall").prop("checked", true);
           } else {
             $("#checkall").removeAttr("checked");
           }

         });
       });
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
