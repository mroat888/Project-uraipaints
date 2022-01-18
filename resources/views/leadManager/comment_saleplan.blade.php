
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">เพิ่มความคิดเห็น</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form_comment_saleplan" enctype="multipart/form-data">
            @csrf
        <div class="modal-body">
            <div>
                <h5>ความคิดเห็น</h5>
            </div>
            <input type="hidden" name="id" id="get_id">
                <div class="card-body">
                    <textarea class="form-control" name="comment" id="get_comment" cols="30" rows="5" placeholder="เพิ่มความคิดเห็น" value=""
                    type="text"></textarea>
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
    $("#form_comment_saleplan").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("lead/create_comment_saleplan") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
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
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });
</script>

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
                $('#get_comment').val(data.dataEdit2.assign_comment_detail);

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
