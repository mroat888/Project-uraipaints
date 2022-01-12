<?php $province = DB::table('province')->get(); ?>
 <!-- Modal -->
     {{-- <div class="modal fade" id="editCustomer" tabindex="-1" role="dialog" aria-labelledby="editCustomer" aria-hidden="true"> --}}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขข้อมูลลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <form action="{{ url('update_customerLead') }}" method="post" enctype="multipart/form-data"> -->
                <form id="form_edit" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                        <input class="form-control" id="edit_shop_id" name="edit_shop_id" type="hidden">
                        <input class="form-control" id="edit_cus_contacts_id" name="edit_cus_contacts_id" type="hidden">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อร้าน</label>
                                <input class="form-control" id="edit_shop_name" name="edit_shop_name" type="text">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">ชื่อผู้ติดต่อ</label>
                                <input class="form-control" id="edit_contact_name" placeholder="" name="edit_contact_name" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">เบอร์โทรศัพท์</label>
                                <input class="form-control" id="edit_customer_contact_phone" placeholder="" name="edit_customer_contact_phone" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="edit_shop_address">ที่อยู่</label>
                                <textarea class="form-control" placeholder="" id="edit_shop_address" name="edit_shop_address" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">จังหวัด</label>
                                <select name="edit_province" id="edit_province" class="form-control province" required>
                                    <option value="">--โปรดเลือก--</option>
                                        @foreach($province as $value)
                                            <option value="{{ $value->PROVINCE_ID }}">{{ $value->PROVINCE_NAME }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">อำเภอ/เขต</label>
                                <select name="edit_amphur" id="edit_amphur" class="form-control amphur">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ตำบล/แขวง</label>
                                <select name="edit_district" id="edit_district" class="form-control district">
                                </select>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="username">รหัสไปรษณีย์</label>
                                <input class="form-control postcode" id="edit_shop_zipcode" placeholder="" name="edit_shop_zipcode" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">รูปภาพ</label>
                                <input class="form-control" id="edit_image" name="edit_image" type="file">
                            </div>
                            <div class="col-md-6 form-group">
                            <label for="firstName">เอกสารแนบ</label>
                            <input class="form-control" id = "edit_shop_fileupload" name="edit_shop_fileupload" type="file">
                        </div>
                        </div>
                        <input type="hidden" name="id" id="get_id"> <!-- ถ้าไม่ใช้ ลบได้ครับ -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" id="btn_save_edit">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    {{-- </div> --}}

<script>
    $("#form_edit").on("submit", function (e) {
        e.preventDefault();
        // var formData = $(this).serialize();
        var formData = new FormData(this);
        //console.log(formData);
        $.ajax({
            type:'POST',
            url: '{{ url("/update_customerLead") }}',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(response){
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                })
                $("#editCustomer").modal('hide');
                location.reload();
            },
            error: function(response){
                console.log("error");
                console.log(response);
            }
        });
    });

    $(document).on('change','#get_province', function(e){
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
                    $('#get_amphur').children().remove().end();
                    $('#get_district').children().remove().end();
                    $('#get_amphur').append('<option selected value="0">--โปรดเลือก--</option>');
                    $('#get_district').append('<option selected value="0">--โปรดเลือก--</option>');
                    $('#get_postcode').val('');
                    $.each(response.amphurs, function(key, value){
                        $('#get_amphur').append('<option value='+value.AMPHUR_ID+'>'+value.AMPHUR_NAME+'</option>')	;
                    });
                }
            }
        });
    });

    $(document).on('change','#get_amphur', function(e){
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
                    $('#get_district').children().remove().end();
                    $('#get_district').append('<option selected value="0">--โปรดเลือก--</option>');
                    $('#get_postcode').val('');
                    $.each(response.districts, function(key, value){
                        $('#get_district').append('<option value='+value.DISTRICT_ID+'>'+value.DISTRICT_NAME+'</option>')	;
                    });
                }
            }
        });
    });

    $(document).on('change','#get_district', function(e){
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
                    $('#get_postcode').val(postcode);
                }
            }
        });
    });


</script>

    <script>
        function displayMessage(message) {
            $(".response").html("<div class='success'>" + message + "</div>");
            setInterval(function() {
                $(".success").fadeOut();
            }, 1000);
        }


    function showselectdate(){
        $("#selectdate").css("display", "block");
        $("#bt_showdate").hide();
    }

    function hidetdate(){
        $("#selectdate").css("display", "none");
        $("#bt_showdate").show();
    }



    </script>



