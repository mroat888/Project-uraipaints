@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">กำหนดค่าต่างๆ</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="edit"></i> บันทึกกำหนดค่าต่างๆ</div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการกำหนดค่า</div>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header my-10">

                                <div class="col-12 mt-10">
                                    <form id="form_update_master_setting" enctype="multipart/form-data">
                                        @csrf
                                        @foreach($master_setting as $value)
                                        <div class="form-group row ">
                                            <input type="hidden" class="form-control" id="set_id[]" name="set_id[]" value="{{ $value->id }}">
                                            <label for="staticEmail" class="col-sm-2 col-form-label" style="text-align:right;">{{ $value->name }} :</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="stipulate[]" name="stipulate[]" value="{{ $value->stipulate }}" max="31">
                                            </div>
                                            <label for="staticEmail" class="col-sm-8 col-form-label" style="text-align:left;">{{ $value->comment }}</label>
                                        </div>
                                        @endforeach
                                        <div class="form-group row ">
                                            <label for="staticEmail" class="col-sm-2 col-form-label" style="text-align:right;"></label>
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-view">บันทึก</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
    </div>
    <!-- /Container -->


<script>
    $("#form_update_master_setting").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("admin/master_setting/update") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // location.reload();
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'แก้ไขข้อมูลไม่สำเร็จ',
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
    $(document).ready(function() {
        $('.delete_master_assignment').click(function(evt) {
            var form = $(this).closest("form");
            evt.preventDefault();

            swal({
                title: `ต้องการลบข้อมูลหรือไม่ ?`,
                text: "ถ้าลบแล้วไม่สามารถกู้คืนข้อมูลได้",
                icon: "warning",
                // buttons: true,
                buttons: [
                    'ยกเลิก',
                    'ตกลง'
                ],
                // infoMode: true
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            })

        });

    });
</script>
@endsection
