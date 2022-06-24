@extends('layouts.masterLead')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item">สั่งงานผู้แทนขาย</li>
        <li class="breadcrumb-item active">แกลลอรี่สั่งงานผู้แทนขาย</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    @include('add_assignment_file_main')

    <script>
        $(document).on('click', '#btn_assignment_delete', function() { // ปุ่มลบ Slaplan
        let assignment_id_delete = $(this).val();
        $('#assignment_id_delete').val(assignment_id_delete);
        $('#ModalProductAssignDelete').modal('show');
    });

    $("#from_assignment_delete").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '{{ url('lead/delete_assignment_file') }}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: "ลบข้อมูลข่าวสารเรียบร้อยแล้ว",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    $('#ModalProductNewDelete').modal('hide');
                    $('#btn_assignment_delete').prop('disabled', true);
                    location.reload();
                },
                error: function(response) {
                    console.log("error");
                    console.log(response);
                }
            });
        });

        $("#form_insert_assignment_gallery").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: '{{ url("lead/create_assignment_gallery") }}',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(response){
                    console.log(response);
                    if(response.status == 200){
                        $("#exampleModalLarge01").modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'บันทึกข้อมูลไม่สำเร็จ',
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

    <script>
        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('lead/edit_assignment_file/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#img_show').children().remove().end();
                    $('#get_id').val(data.dataEdit.id);

                let img_name = '{{ asset("/public/upload/AssignmentFile") }}/' + data.dataEdit.image;
                if(data.dataEdit.image != ""){
                    // ext = data.dataEdit.image.split('.').pop().toLowerCase();
                    console.log(img_name);
                    if(img_name){
                        $('#img_show').append('<img src = "'+img_name+'" style="max-width:20%;">');
                    }
                }

                    $('#editAssignment').modal('toggle');
                }
            });
        }
    </script>

@endsection
