<?php
$master_present = App\MasterPresentSaleplan::orderBy('id', 'desc')->get();
?>

<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">สร้าง Sale Plan (นำเสนอสินค้า)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="form_insert_saleplan" enctype="multipart/form-data">
        {{-- <form action="{{ url('create_saleplan') }}" method="post" enctype="multipart/form-data"> --}}
            @csrf
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="username">วัตถุประสงค์</label>
                    <select class="form-control custom-select" name="sale_plans_objective" required>
                        <option value="" selected>กรุณาเลือก</option>
                        @foreach ($objective as $value)
                        <option value="{{$value->id}}">{{$value->masobj_title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 form-group">
                    <label for="firstName">ค้นหาชื่อร้าน</label>
                    <select name="sel_searchShop2" id="sel_searchShop2" class="form-control custom-select select2" required>
                        <option value="" selected disabled>กรุณาเลือกชื่อร้านค้า</option>
                        @if (isset($customer_api) && !is_null($customer_api))
                        @foreach ($customer_api as $key => $value)
                        <option value="{{$customer_api[$key]['id']}}">{{$customer_api[$key]['shop_name']}}</option>
                    @endforeach
                        @endif

                    </select>
                </div>
            </div>
                <input type="hidden" name="shop_id" id="saleplan_id">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="firstName">ผู้ติดต่อ</label>
                        <input class="form-control" id="saleplan_contact_name" type="text" readonly>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="firstName">เบอร์โทรศัพท์</label>
                        <input class="form-control" id="saleplan_phone" type="text" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username">ที่อยู่ร้าน</label>
                    <textarea class="form-control" id="saleplan_address" cols="30" rows="5" placeholder="" value=""
                        type="text" readonly> </textarea>
                </div>
                <div class="row">
                {{-- <div class="col-md-6 form-group"> --}}
                    {{-- <label for="firstName">วันที่</label> --}}
                    <input class="form-control" type="hidden" name="sale_plans_date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>"/>
                {{-- </div> --}}

                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="firstName">รายการนำเสนอ</label>
                        <select class="select2 select2-multiple form-control" multiple="multiple" data-placeholder="Choose" name="sale_plans_tags[]" required>
                            <optgroup label="เลือกข้อมูล">
                                @foreach ($pdglists_api as $key => $value)
                                <option value="{{ $pdglists_api[$key]['identify'] }}">{{ $pdglists_api[$key]['name'] }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$monthly_plan_id}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </div>
    </form>
    </div>
</div>

        <script>
            $("#form_insert_saleplan").on("submit", function (e) {
                e.preventDefault();
                // var formData = $(this).serialize();
                var formData = new FormData(this);
                //console.log(formData);
                $.ajax({
                    type:'POST',
                    url: '{{ url("create_saleplan") }}',
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(response){
                        console.log(response);
                        if(response.status == 200){
                            $("#saleplanAdd").modal('hide');
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
        </script>


<script>
    $(document).ready(function() {


        $("#sel_searchShop2").on("change", function (e) {
            //alert('ssdsd');
            e.preventDefault();
            let shop_id = $(this).val();
            console.log(shop_id);
            $('#saleplan_id').val('');
            // $('#get_contact_name').val(response.contact_name);
            $('#saleplan_contact_name').val('');
            $('#saleplan_phone').val('');
            $('#saleplan_address').val('');
            $.ajax({
                method: 'GET',
                url: '{{ url("/searchShop_saleplan") }}/'+shop_id,
                datatype: 'json',
                success: function(response){
                    console.log(response[0])
                    $('#saleplan_id').val(response[0].id);
                    // $('#get_contact_name').val(response.contact_name);
                    $('#saleplan_phone').val(response[0].shop_phone);
                    $('#visit_mobile').val(response[0].shop_mobile);
                    $('#saleplan_address').val(response[0].shop_address);
                },
                error: function(response){
                    console.log("error");
                    console.log(response);
                }
            });
        });

    });

</script>

        {{-- <script>
            $(document).ready(function() {
                $("#sel_searchShop2").on("change", function (e) {
                    //alert('ssdsd');
                    e.preventDefault();
                    let shop_id = $(this).val();
                    console.log(shop_id);
                    $.ajax({
                        method: 'GET',
                        url: '{{ url("searchShop_saleplan") }}/'+shop_id,
                        datatype: 'json',
                        success: function(response){
                            console.log(response)
                            $('#saleplan_id').val(response.id);
                            $('#saleplan_contact_name').val(response.customer_contact_name);
                            $('#saleplan_phone').val(response.customer_contact_phone);
                            $('#saleplan_address').val(response.shop_address);
                        },
                        error: function(response){
                            console.log("error");
                            console.log(response);
                        }
                    });
                });
            });

        </script> --}}
