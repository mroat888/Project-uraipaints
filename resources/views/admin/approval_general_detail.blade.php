@extends('layouts.masterAdmin')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active">การขออนุมัติ</li>
            <li class="breadcrumb-item active" aria-current="page">รายการข้อมูลการขออนุมัติ</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">

        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="file-text"></i></span></span>รายการข้อมูลการขออนุมัติ</h4>
            </div>
            <div class="d-flex">
                <a href="{{ url('admin/approvalgeneral')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    {{-- <div class="row">
                        <div class="col-sm">
                            <a href="{{ url('admin/approvalgeneral') }}" type="button" class="btn btn-violet btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-file"></i>
                                </span>
                                <span class="btn-text">รออนุมัติ</span>
                            </a>

                            <a href="{{ url('admin/approvalgeneral/history') }}" type="button" class="btn btn-secondary btn-wth-icon icon-wthot-bg btn-sm text-white">
                                <span class="icon-label">
                                    <i class="fa fa-list"></i>
                                </span>
                                <span class="btn-text">ประวัติ</span>
                            </a>
                            <hr>
                            <div id="calendar"></div>
                        </div>
                    </div> --}}
                    <div class="row mb-2">
                            <div class="col-md-12">
                                <h5 class="hk-sec-title">ตารางรายการข้อมูลการขออนุมัติ</h5>
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
                                            <th>วันที่</th>
                                            <th>เรื่อง</th>
                                            <th>พนักงาน</th>
                                            <th>การอนุมัติ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($request_approval as $key => $value)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$value->assign_request_date}}</td>
                                            <td>

                                                @if ($value->assign_is_hot == 1)
                                                <span class="badge badge-soft-danger" style="font-size: 12px;">HOT</span>
                                                @endif

                                                {{$value->assign_title}}
                                            </td>
                                            <td>{{$value->name}}</td>
                                            <td>

                                                            @if ($value->status_approve == 0)
                                                                <span class="badge badge-soft-warning"
                                                                    style="font-size: 12px;">
                                                                    Pending
                                                                </span>
                                                            @elseif ($value->status_approve == 1)
                                                                <span class="badge badge-soft-success"
                                                                    style="font-size: 12px;">
                                                                    Approve
                                                                </span>
                                                                @elseif ($value->status_approve == 2)
                                                                <span class="badge badge-soft-danger"
                                                                    style="font-size: 12px;">
                                                                    Reject
                                                                </span>
                                                            @endif
                                                {{-- <span class="badge badge-soft-warning" style="font-size: 12px;">Pending</span> --}}
                                            </td>
                                            <td>
                                                <button onclick="edit_modal({{ $value->id }})" type="button" class="btn btn-icon btn-violet mr-10"
                                                    data-original-title="ดูรายละเอียด" data-toggle="tooltip" data-toggle="modal" data-target="editApproval">
                                                    <i data-feather="eye"></i></button>

                                                <a href="{{ url('admin/comment_approval', [$value->id, $value->created_by]) }}" class="btn btn-icon btn-info mr-10">
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
        </div>
    </form>
        <!-- /Row -->
    </div>
    <!-- /Container -->

    <!-- Modal Edit -->
    <div class="modal fade" id="editApproval" tabindex="-1" role="dialog" aria-labelledby="editApproval" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดข้อมูลการขออนุมัติ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form action="{{ url('update_approval') }}" method="post" enctype="multipart/form-data">
                    @csrf --}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ขออนุมัติสำหรับ</label>
                                    <select class="form-control custom-select" name="approved_for" id="get_for" readonly>
                                        <option selected disabled>เลือก</option>
                                        <?php $masters = App\ObjectiveAssign::get(); ?>
                                    @foreach ($masters as $value)
                                    <option value="{{$value->id}}">{{$value->masassign_title}}</option>
                                    @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">หัวข้อ / เรื่อง</label>
                                <input class="form-control" placeholder="กรุณาใส่หัวข้อ / เรื่อง" name="assign_title" id="get_title" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">วันที่ / Date</label>
                                <input class="form-control" type="date" name="assign_work_date" id="get_work_date" min="<?= date('Y-m-d') ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="username">รายละเอียด</label>
                                <textarea class="form-control" cols="30" rows="5" id="get_detail" name="assign_detail"
                                    type="text" readonly></textarea>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="firstName">เรื่องด่วน</label>
                                    <div class="custom-control custom-checkbox">
                                        <div id="customCheck6"></div>
                                    </div>
                                </div>
                        </div>

                        <input type="hidden" name="id" id="get_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        {{-- <button type="submit" class="btn btn-primary">บันทึก</button> --}}
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>

    <script>
        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('admin/view_approval/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#customCheck6').children().remove().end();
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_work_date').val(data.dataEdit.assign_work_date);
                    $('#get_title').val(data.dataEdit.assign_title);
                    $('#get_detail').val(data.dataEdit.assign_detail);
                    $('#get_for').val(data.dataEdit.approved_for);
                    $('#get_xx').val(data.dataEdit.assign_is_hot);

                    if (data.dataEdit.assign_is_hot == 1) {
                        $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck7' name='assign_is_hot' value='1' checked readonly><label class='custom-control-label' for='customCheck7' readonly>ขออนุมัติด่วน</label>");
                    }else{
                        $('#customCheck6').append("<input type='checkbox' class='custom-control-input' id='customCheck8' name='assign_is_hot' value='1' readonly><label class='custom-control-label' for='customCheck8' readonly>ขออนุมัติด่วน</label>");
                    }
                    // $('#customCheck2').val(data.dataEdit.assign_is_hot);

                    $('#editApproval').modal('toggle');
                }
            });
        }
    </script>


@endsection('content')

@section('scripts')


@endsection
