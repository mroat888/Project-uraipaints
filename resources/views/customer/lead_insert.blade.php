<?php $province = DB::table('province')->get();

      $objective_cust_new = App\MasterCustomerNew::get();

?>
<!-- <div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="addCustomer" aria-hidden="true"> -->
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มข้อมูลลูกค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <!-- <form action="{{ url('create_customer') }}" method="post" enctype="multipart/form-data"> --> --}}
            <form id="form_insert" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                    @if(isset($customer_shops ))
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="objective">วัตถุประสงค์</label>
                                <select class="form-control custom-select" name="customer_shop_objective" required>
                                    <option selected>กรุณาเลือก</option>
                                    @foreach ($objective_cust_new as $value)
                                    <option value="{{$value->id}}">{{$value->cust_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ค้นหาชื่อร้าน</label>
                                <select name="customer_shops" id="customer_shops" class="form-control custom-select select2">
                                    <option value="">--โปรดเลือก--</option>
                                        @foreach($customer_shops as $value)
                                            <option value="{{ $value->id }}">{{ $value->shop_name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <input class="form-control" id="customer_shops_id" name="customer_shops_id" type="hidden">
                                <input class="form-control" id="is_monthly_plan" name="is_monthly_plan" type="hidden">
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">ชื่อร้าน</label>
                            <input class="form-control" id="shop_name" name="shop_name" type="text">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="firstName">ชื่อผู้ติดต่อ</label>
                            <input class="form-control" id="contact_name" name="contact_name"  type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">เบอร์โทรศัพท์</label>
                            <input class="form-control" id="shop_phone" name="shop_phone" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="firstName">ที่อยู่</label>
                            <textarea class="form-control" id="shop_address" name="shop_address" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">จังหวัด</label>
                            <select name="province" id="province" class="form-control province" required>
                                <option value="">--โปรดเลือก--</option>
                                    @foreach($province as $value)
                                        <option value="{{ $value->PROVINCE_ID }}">{{ $value->PROVINCE_NAME }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="firstName">อำเภอ/เขต</label>
                            <select name="amphur" id="amphur" class="form-control amphur" required>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">ตำบล/แขวง</label>
                            <select name="district" id="district" class="form-control district" required>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="username">รหัสไปรษณีย์</label>
                            <input class="form-control postcode" id="postcode" name="shop_zipcode" type="text">
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">รูปภาพ</label>
                            <input class="form-control" name="image" type="file">
                        </div>
                        <div class="col-md-6 form-group">
                        <label for="firstName">เอกสารแนบ</label>
                            <input class="form-control" name="shop_fileupload" type="file">
                        </div>
                    </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </div>
        </form>
        </div>
    </div>
<!-- </div> -->

<script>
    $("#form_insert").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/create_customer") }}',
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
                    });
                    $("#addCustomer").modal('hide');
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

<script>
    document.getElementById('btn_approve').onclick = function() {
        var markedCheckbox = document.getElementsByName('checkapprove');
        var saleplan_id_p = "";

        for (var checkbox of markedCheckbox) {
            if (checkbox.checked) {
                if (checkbox.value != "") {
                    saleplan_id_p += checkbox.value + ' ,';
                }
            }
        }
        if (saleplan_id_p != "") {
            $('#Modalapprove').modal('show');
            $('#saleplan_id').val(saleplan_id_p);
        } else {
            alert('กรุณาเลือกรายการด้วยค่ะ');
        }
    }

    function showselectdate() {
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate() {
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }
</script>

<script>
$(document).on('click','.btn_editshop', function(e){
    e.preventDefault();
    let shop_id = $(this).val();

    $.ajax({
        method: 'GET',
        url: '{{ url("/edit_customerLead") }}/'+shop_id,
        datatype: 'json',
        success: function(response){
            //console.log(response);
            if(response.status == 200){
                $("#editCustomer").modal('show');
                $(".modal-title").text('แก้ไขข้อมูลลูกค้า');
                $("#edit_shop_id").val(shop_id);
                $("#edit_shop_name").val(response.dataEdit.shop_name);
                // $("#edit_shop_objective2").val(response.dataEdit.cust_name);
                $('#edit_shop_objective').append('<option value='+response.dataEdit.customer_shop_objective+' selected>'+response.dataEdit.cust_name+'</option>')	;
                if(response.customer_contacts != null){
                    $("#edit_cus_contacts_id").val(response.customer_contacts.id);
                    $("#edit_contact_name").val(response.customer_contacts.customer_contact_name);
                    $("#edit_customer_contact_phone").val(response.customer_contacts.customer_contact_phone);
                }
                $("#edit_shop_address").val(response.dataEdit.shop_address);

                $.each(response.shop_province, function(key, value){
                    if(value.PROVINCE_ID == response.dataEdit.shop_province_id){
                        $('#edit_province').append('<option value='+value.PROVINCE_ID+' selected>'+value.PROVINCE_NAME+'</option>')	;
                    }else{
                        $('#edit_province').append('<option value='+value.PROVINCE_ID+'>'+value.PROVINCE_NAME+'</option>')	;
                    }
                });

                $.each(response.shop_amphur, function(key, value){
                    if(value.AMPHUR_ID == response.dataEdit.shop_amphur_id){
                        $('#edit_amphur').append('<option value='+value.AMPHUR_ID+' selected>'+value.AMPHUR_NAME+'</option>')	;
                    }else{
                        $('#edit_amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                    }
                });

                $.each(response.shop_district, function(key, value){
                    if(value.DISTRICT_ID == response.dataEdit.shop_district_id){
                        $('#edit_district').append('<option value='+value.DISTRICT_ID+' selected>'+value.DISTRICT_NAME+'</option>')	;
                    }else{
                        $('#edit_district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                    }
                });

                $("#edit_shop_zipcode").val(response.dataEdit.shop_zipcode);


            }
        }
    });

})


$(document).on('change','.customer_shops_sel', function(e){
    e.preventDefault();
    let pvid = $(this).val();
    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_amphur") }}/'+pvid,
        datatype: 'json',
        success: function(response){
            //alert(response.AMPHUR_NAME);
            if(response.status == 200){
                //console.log(response)
                $('.amphur').children().remove().end();
                $('.district').children().remove().end();
                $('.amphur').append('<option selected value="0">--โปรดเลือก--</option>');
                $('.district').append('<option selected value="0">--โปรดเลือก--</option>');
                $('.postcode').val('');
                $.each(response.amphurs, function(key, value){
                    $('.amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                });
            }
        }
    });
});

$(document).on('change','.province', function(e){
    e.preventDefault();
    let pvid = $(this).val();
    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_amphur") }}/'+pvid,
        datatype: 'json',
        success: function(response){
            //alert(response.AMPHUR_NAME);
            if(response.status == 200){
                //console.log(response)
                $('.amphur').children().remove().end();
                $('.district').children().remove().end();
                $('.amphur').append('<option selected value="0">--โปรดเลือก--</option>');
                $('.district').append('<option selected value="0">--โปรดเลือก--</option>');
                $('.postcode').val('');
                $.each(response.amphurs, function(key, value){
                    $('.amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                });
            }
        }
    });
});

$(document).on('change','.amphur', function(e){
    e.preventDefault();
    let amid = $(this).val();
    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_district") }}/'+amid,
        datatype: 'json',
        success: function(response){
            //alert(response.AMPHUR_NAME);
            if(response.status == 200){
                //console.log(response)
                $('.district').children().remove().end();
                $('.district').append('<option selected value="0">--โปรดเลือก--</option>');
                $('.postcode').val('');
                $.each(response.districts, function(key, value){
                    $('.district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                });
            }
        }
    });
});

$(document).on('change','.district', function(e){
    e.preventDefault();
    let disid = $(this).val();
    $.ajax({
        method: 'GET',
        url: '{{ url("/fetch_postcode") }}/'+disid,
        datatype: 'json',
        success: function(response){
            if(response.status == 200){
                //console.log(response)
                let postcode = response.postcode.POSTCODE;
                $('.postcode').val(postcode);
            }
        }
    });
});
</script>
