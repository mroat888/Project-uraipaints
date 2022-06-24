
    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
         <!-- Title -->
         <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="image"></i> แกลลอรี่สั่งงาน</div>
            <div class="content-right d-flex">
                <button type="button" class="btn-green" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>
                @if (Auth::user()->status == 2)
                <a href="{{url('add_assignment')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
                    @elseif (Auth::user()->status == 3)
                    <a href="{{url('head/assignment/add')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
                        @elseif (Auth::user()->status == 4)
                        <a href="{{url('admin/assignment-add')}}" type="button" class="btn btn-secondary btn-rounded ml-2"> ย้อนกลับ</a>
                @endif
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการแกลลอรี่สั่งงาน</div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="table-responsive table-color col-md-12">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รูปภาพ</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assign_gallery as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><img src="{{ isset($value->image) ? asset('public/upload/AssignmentFile/' . $value->image) : '' }}" width="100"></td>
                                        <td>
                                            <div class="button-list">
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-edit" data-toggle="modal" data-target="#editAssignment">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">
                                                            drive_file_rename_outline</span></h4>
                                                        </button>
                                                        <button id="btn_assignment_delete" class="btn btn-icon btn-danger"
                                                             value="{{ $value->id }}">
                                                             <h4 class="btn-icon-wrap" style="color: white;"><span class="material-icons">
                                                                delete_outline
                                                                </span></h4>
                                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>
    <!-- /Container -->

     <!-- Modal -->
     <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มแกลลอรี่</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_assignment_gallery" enctype="multipart/form-data">
                {{-- <form action="{{ url('admin/create_assignment_gallery') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                    <input type="hidden" name="assignment_id" value="{{$id}}">
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="assignment_gallery[]" multiple class="form-control">
                            </div>

                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editAssignment" tabindex="-1" role="dialog" aria-labelledby="editAssignment" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขรูปภาพ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if (Auth::user()->status == 2)
                <form action="{{ url('lead/update_assignment_file') }}" method="post" enctype="multipart/form-data">
                    @elseif (Auth::user()->status == 3)
                    <form action="{{ url('head/update_assignment_file') }}" method="post" enctype="multipart/form-data">
                        @elseif (Auth::user()->status == 4)
                        <form action="{{ url('admin/update_assignment_file') }}" method="post" enctype="multipart/form-data">
                @endif
                    @csrf
                    <input type="hidden" name="id" id="get_id">
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                            <span id="img_show" class="mt-5"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input type="file" name="assignment_gallery" id="get_image" class="form-control">
                            </div>

                </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>


    <!-- Modal Delete Saleplan -->
    <div class="modal fade" id="ModalProductAssignDelete" tabindex="-1" role="dialog" aria-labelledby="ModalProductAssignDelete"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="from_assignment_delete" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">คุณต้องการลบรูปภาพใช่หรือไม่</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <h3>คุณต้องการลบรูปภาพใช่หรือไม่ ?</h3>
                        <input class="form-control" id="assignment_id_delete" name="assignment_id_delete" type="hidden" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="btn_save_edit">ยืนยัน</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
