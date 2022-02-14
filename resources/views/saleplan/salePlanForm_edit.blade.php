
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">แก้ไข Sale Plan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form_update_saleplan" enctype="multipart/form-data">
        {{-- <form action="{{ url('update_saleplan') }}" method="post" enctype="multipart/form-data"> --}}
            @csrf
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="firstName">เรื่อง</label>
                    <input class="form-control" id="get_title" type="text" name="sale_plans_title">
                </div>
                <div class="form-group col-md-6">
                    <label for="username">วัตถุประสงค์</label>
                    <select class="form-control custom-select" name="sale_plans_objective" id="get_objective">
                        <option selected disabled>กรุณาเลือก</option>
                        @foreach ($objective as $value)
                            <option value="{{$value->id}}">{{$value->masobj_title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="firstName">ค้นหาชื่อร้าน</label>
                        <select name="sel_searchShopEdit" id="sel_searchShopEdit" class="form-control custom-select select2">
                            <option value="" selected disabled>เลือกข้อมูล</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="shop_id" id="saleplan_id_edit">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="firstName">ผู้ติดต่อ</label>
                        <input class="form-control" id="saleplan_contact_name_edit" type="text" readonly>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="firstName">เบอร์โทรศัพท์</label>
                        <input class="form-control" id="saleplan_phone_edit" type="text" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username">ที่อยู่ร้าน</label>
                    <textarea class="form-control" id="saleplan_address_edit"  cols="30" rows="5" placeholder="" value=""
                        type="text" readonly> </textarea>
                </div>
                <div class="row">
                    <input class="form-control" type="hidden" name="sale_plans_date" id="get_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>"/>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="firstName">รายการนำเสนอ</label>
                        <select class="select2 select2-multiple form-control" multiple="multiple" name="sale_plans_tags"  id="get_tags">
                            {{-- <optgroup id="get_tags">
                                <option value="1">เพิ่มเติม</option>
                                <option value="2">เข้าพบลูกค้า</option>
                                <option value="3">งานใหม่</option>
                            </optgroup> --}}
                        </select>
                        {{-- <input type="text" name="" id="get_tag"> --}}
                    </div>
                </div>
                <input type="hidden" name="id" id="get_id2">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </div>
    </form>
    </div>
</div>

{{-- <script>
    //Edit
    function edit_modal(id) {
        $.ajax({
            type: "GET",
            url: "{!! url('edit_saleplan/"+id+"') !!}",
            dataType: "JSON",
            async: false,
            success: function(data) {
                $('#get_id2').val(data.dataEdit.id);
                $('#get_date').val(data.dataEdit.sale_plans_date);
                $('#get_title').val(data.dataEdit.sale_plans_title);
                $('#get_objective').val(data.dataEdit.sale_plans_objective);
                $('#get_tag').val(data.dataEdit.sale_plans_tags);
                $('#saleplan_id_edit').val(data.dataEdit.shop_id);
                $('#saleplan_contact_name_edit').val(data.dataEdit.customer_contact_name);
                $('#saleplan_phone_edit').val(data.dataEdit.customer_contact_phone);
                $('#saleplan_address_edit').val(data.dataEdit.shop_address);

                $('#saleplanEdit').modal('toggle');
            }
        });
    }

</script> --}}

<script>

    $("#form_update_saleplan").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: '{{ url("update_saleplan") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                if(response.status == 200){
                    $("#saleplanEdit").modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
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


    // $(document).ready(function() {
    //     $("#sel_searchShopEdit").on("change", function (e) {
    //         //alert('ssdsd');
    //         e.preventDefault();
    //         let shop_id = $(this).val();
    //         console.log(shop_id);
    //         $('#saleplan_contact_name_edit').val();
    //         $('#saleplan_phone_edit').val();
    //         $('#saleplan_address_edit').val();
    //         $.ajax({
    //             method: 'GET',
    //             url: '{{ url("searchShop_saleplan") }}/'+shop_id,
    //             datatype: 'json',
    //             success: function(response){
    //                 console.log(response[0])
    //                 $('#saleplan_id_edit').val(response[0].id);
    //                 $('#saleplan_contact_name_edit').val(response[0].contact_name);
    //                 $('#saleplan_phone_edit').val(response[0].shop_phone);
    //                 $('#saleplan_address_edit').val(response[0].shop_address);
    //             },
    //             error: function(response){
    //                 console.log("error");
    //                 console.log(response);
    //             }
    //         });
    //     });
    // });

</script>
