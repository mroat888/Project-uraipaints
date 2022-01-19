
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">เพิ่มความคิดเห็น</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div>
                <h5>ความคิดเห็น</h5>
            </div>
                <div class="card-body">
                    <textarea class="form-control" id="address" cols="30" rows="5" placeholder="" value=""
                    type="text"></textarea>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </div>
    </div>
</div>

<div class="modal fade" id="Modalapprov_reject" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" style="color:#FFF;">ยืนยันการปฎิเสธ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#FFF;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:center">
                <h3>ต้องการปฎิเสธ ใช่หรือไม่?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary bt_save"><i data-feather="check" style="width:18px;"></i> ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Modalapprov_approve" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" style="color:#FFF;">ยืนยันการอนุมัติ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:center">
                <h3>ต้องการอนุมัติ ใช่หรือไม่?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary bt_save"><i data-feather="check" style="width:18px;"></i> ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<script>
    //Edit
    function edit_modal(id) {
        $.ajax({
            type: "GET",
            url: "{!! url('comment_saleplan/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#get_id').val(data.dataEdit.id);

                $('#exampleModalLarge02').modal('toggle');
            }
        });
    }
</script>


<script>
    $(document).on('click', '.bt_reject', function(){
       // alert('ไม่อนุมัติ');
       $('#Modalapprov_reject').modal("show");
    });

    $(document).on('click', '.bt_saveapprove', function(){
       // alert('ไม่อนุมัติ');
       $('#Modalapprov_approve').modal("show");
    });

</script>
