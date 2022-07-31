<!-- Modal Result -->
<div class="modal fade" id="ModalResult_show" tabindex="-1" role="dialog" aria-labelledby="ModalResult_show" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">บันทึกส่งผลดำเนินการ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">สั่งงานเรื่อง : <span id="header_title_history"></span></h5>
                            <div class="my-3"><span>ผู้สั่งงาน : </span><span id="get_assign_approve_id_history"></span></div>
                            <div class="my-3"><span>วันที่ปฎิบัติ : </span><span id="get_assign_work_date_history"></span></div>

                            <div class="my-3">
                                <p>รายละเอียด : </p>
                                <p id="get_detail_history" class="card-text"></p>
                            </div>

                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="firstName">ไฟล์เอกสาร : </label>
                                    <div id="img_show_text_history" class="mt-5"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="username">ผลดำเนินงาน</label>
                            <p id="assign_result_detail_history"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="firstName">ไฟล์เอกสาร</label>

                            <div id="img_show_text_result_history" class="mt-5"></div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <!-- <button type="submit" class="btn btn-primary">ส่งงาน</button> -->
                </div>

            </div>


    </div>
</div>

<script>


//Show
function assignment_show_result(id) {
    console.log(id);
    $.ajax({
        type: "GET",
        url: "{!! url('assignment_result_get/"+id+"') !!}",
        dataType: "JSON",
        async: false,
        success: function(data) {
            console.log(data);
            $('#img_show_text_history').children().remove().end();
            $('#img_show_text_result_history').children().remove().end();

            $('#get_detail_history').text(data.dataResult.assign_detail);
            $('#header_title_history').text(data.dataResult.assign_title);
            $('#get_assign_approve_id_history').text(data.emp_approve.name);

            let work_date_history = data.dataResult.assign_work_date.split("-");
            let year_th_history = parseInt(work_date_history[0])+543;
            let date_work_history = work_date_history[2]+"/"+work_date_history[1]+"/"+year_th_history;

            $('#get_assign_work_date_history').text(date_work_history);

            $.each(data.dataGallery, function(key, value){
                    let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataGallery[key]['image'];
                    if(data.dataGallery[key]['image'] != ""){
                        ext = data.dataGallery[key]['image'].split('.').pop().toLowerCase();
                        console.log(img_name);
                        if(ext == "pdf"){
                            $('#img_show_text_history').append('<span><a href="'+img_name+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                        }else{
                            $('#img_show_text_history').append('<a href="'+img_name+'" target="_blank"><img src = "'+img_name+'" style="max-width:20%;"></a>');
                        }
                    }
                });

            $('#assign_result_detail_history').text(data.dataResult.assign_result_detail);

            let img_name2 = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataResult.assign_result_fileupload;
            if(data.dataResult.assign_result_fileupload != ""){
                ext = data.dataResult.assign_result_fileupload.split('.').pop().toLowerCase();
                if(ext == "pdf"){
                    $('#img_show_text_result_history').append('<span><a href="'+img_name2+'" target="_blank">เปิดไฟล์ PDF</a></span>');
                }else{
                    $('#img_show_text_result_history').append('<a href="'+img_name2+'" target="_blank"><img src = "'+img_name2+'" style="max-width:20%;"></a>');
                }
            }

            $('#ModalResult_show').modal('toggle');
        }
    });
}


</script>
