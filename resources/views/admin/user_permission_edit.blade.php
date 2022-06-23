
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">แก้ไขข้อมูลผู้ใช้งาน</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form_edit" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="edit_tuser_id" id="edit_tuser_id">
                    <div class="col-md-12 form-group">
                        <label for="firstName">ชื่อผู้ใช้งาน</label>
                        <input type="text" name="edit_tname" id="edit_tname" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="firstName">อีเมล์</label>
                        <input type="email" name="edit_temail" id="edit_temail" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="firstName">รหัสผ่าน</label>
                        <input type="password" name="edit_tpassword" id="edit_tpassword" class="form-control" placeholder="password">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="username">สิทธิ์การใช้งาน</label>
                        <select id="edit_sel_status" name="edit_sel_status" class="form-control custom-select">
                            <option value="" selected disabled>เลือกข้อมูล</option>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username">ชื่อพนักงาน</label>
                        <select name="edit_sel_api_identify" id="edit_sel_api_identify" class="form-control custom-select select2">
                            <option value="" selected disabled>เลือกข้อมูล</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="username">ทีม</label>
                        <select id="edit_sel_team" name="edit_sel_team[]" class="form-control custom-select select2 select2-multiple"  multiple="multiple">
                            <option selected disabled>เลือกข้อมูล</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <span id="img_show" class="mt-5"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="firstName">รูปภาพ (ลายเซ็นต์) </label>
                        <input type="file" name="image" class="form-control">
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

<script>
     $("#form_edit").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/admin/userPermissionUpdate") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $("#modaledit").modal('hide');
                    location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Your work has been saved',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });
</script>
