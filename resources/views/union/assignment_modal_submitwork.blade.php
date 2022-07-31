<!-- Modal Result -->
<div class="modal fade" id="ModalResult" tabindex="-1" role="dialog" aria-labelledby="ModalResult" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

        <form id="form_assignment_result" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">บันทึกส่งผลการดำเนินการ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">สั่งงานเรื่อง : <span id="header_title"></span></h5>
                            <div class="my-3"><span>ผู้สั่งงาน : </span><span id="get_assign_approve_id"></span></div>
                            <div class="my-3"><span>วันที่ปฎิบัติ : </span><span id="get_assign_work_date"></span></div>

                            <div class="my-3">
                                <p>รายละเอียด : </p>
                                <p  id="get_detail" class="card-text"></p>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="firstName">ไฟล์เอกสาร : </label>
                                    <div id="img_show_text" class="mt-5"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="assign_id" id="get_assign_id">
                    <input type="hidden" name="assign_result_status" id="assign_result_status" value="3">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="username">รายละเอียด</label>
                            <textarea class="form-control" id="assign_result_detail" name="assign_result_detail" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="firstName">ไฟล์เอกสาร</label>
                            <input type="file" name="assign_result_fileupload" id="assign_result_fileupload" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">ส่งงาน</button>
                </div>

            </div>
        </form>

    </div>
</div>

<script>

$("#form_assignment_result").on("submit", function (e) {
    e.preventDefault();
    //var formData = $(this).serialize();
    var formData = new FormData(this);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: '{{ url("assignment_Result") }}',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(response){
            console.log(response);
            Swal.fire({
                icon: 'success',
                title: 'Submit Success',
                text: "ส่งงานเรียบร้อยแล้ว",
                showConfirmButton: false,
                timer: 1500
            });
            $('#ModalResult').modal('hide');
            location.reload();
        },
        error: function(response){
            console.log("error");
            console.log(response);
        }
    });
});


//Edit
function assignment_result(id) {
    // $("#get_assign_id").val(id);
    $.ajax({
        type: "GET",
        url: "{!! url('assignment_result_get/"+id+"') !!}",
        dataType: "JSON",
        async: false,
        success: function(data) {
            // console.log(data);
            $('#img_show_text').children().remove().end();

            $('#get_assign_id').val(data.dataResult.id);
            $('#get_detail').text(data.dataResult.assign_detail);
            $('#header_title').text(data.dataResult.assign_title);
            $('#get_assign_approve_id').text(data.emp_approve.name);

                let assign_work_date = data.dataResult.assign_work_date.split(" ");
                let assign_work_date2 = assign_work_date[0].split("-");
                let work_year_th = parseInt(assign_work_date2[0])+543;
                let date_work = assign_work_date2[2]+"/"+assign_work_date2[1]+"/"+work_year_th;
                $('#get_assign_work_date').text(date_work);

                $.each(data.dataGallery, function(key, value){
                    let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataGallery[key]['image'];
                    if(data.dataGallery[key]['image'] != ""){
                        ext = data.dataGallery[key]['image'].split('.').pop().toLowerCase();
                        console.log(img_name);
                        if(ext == "pdf"){
                            $('#img_show_text').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show_text').append('<a href="'+img_name+'" target="_blank"><img src = "'+img_name+'" style="max-width:30%;"></a>');
                        }
                    }
                });


            if (data.dataResult.assign_result_status != 0) {
                $('#get_result').val(data.dataResult.assign_result_status);
            }

            $('#ModalResult').modal('toggle');
        }
    });
}


</script>
