<?php $objective = App\ObjectiveSaleplan::all();

$customer_shops = DB::table('customer_shops')
        ->whereIn('shop_status', [0, 1]) // ดึงเฉพาะ ลูกค้าเป้าหมายและทะเบียนลูกค้า
        ->where('created_by',Auth::user()->id)
        ->orderby('shop_name','asc')
        ->get();

        ?>

<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไข Sale Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('update_saleplan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label for="firstName">เรื่อง</label>
                            <input class="form-control" id="get_title" type="text" name="sale_plans_title">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ค้นหาชื่อร้าน</label>
                                {{-- <input class="form-control" id="searchShop2" type="text"> --}}
                                <select name="sel_searchShopEdit" id="sel_searchShopEdit" class="form-control custom-select select2">
                                    <option value="" selected disabled>กรุณาเลือกชื่อร้านค้า</option>
                                    @foreach ($customer_shops as $value)
                                    <option value="{{$value->id}}">{{$value->shop_name}}</option>
                                    @endforeach
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
                            <textarea class="form-control" id="saleplan_address_edit" cols="30" rows="5" placeholder="" value=""
                                type="text" readonly> </textarea>
                        </div>
                        <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">วันที่</label>
                            <input class="form-control" type="date" name="sale_plans_date" id="get_date" min="<?= date('Y-m-d') ?>"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="username">วัตถุประสงค์</label>
                            <select class="form-control custom-select" name="sale_plans_objective" id="get_objective">
                                <option selected>กรุณาเลือก</option>
                                @foreach ($objective as $value)
                                <option value="{{$value->id}}">{{$value->masobj_title}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="firstName">รายการนำเสนอ</label>
                                <select class="select2 select2-multiple form-control" multiple="multiple" data-placeholder="Choose" name="sale_plans_tags" id="get_tag">
                                    <optgroup label="เลือกข้อมูล">
                                        <option value="1">สีรองพื้นปูนกันชื้น</option>
                                        <option value="2">4 in 1</option>
                                    </optgroup>
                                </select>
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

        <script>
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
                        $('#saleplan_contact_name_edit').val(data.dataEdit.contact_name);
                        $('#saleplan_phone_edit').val(data.dataEdit.shop_phone);
                        $('#saleplan_address_edit').val(data.dataEdit.shop_address);

                        $('#saleplanEdit').modal('toggle');
                    }
                });
            }
        </script>

<script>
    $(document).ready(function() {
        $("#sel_searchShopEdit").on("change", function (e) {
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
                    $('#saleplan_id_edit').val(response.id);
                    $('#saleplan_contact_name_edit').val(response.contact_name);
                    $('#saleplan_phone_edit').val(response.shop_phone);
                    $('#saleplan_address_edit').val(response.shop_address);
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
        $('#searchShop2').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: "searchShop_saleplan",
                type: "GET",
                data: {
                    'search': query
                },
                success: function(data) {
                    // $('#search_list').html(data);
                $('#get_shop_id').val(data.id);
                $('#get_contact_name2').val(data.contact_name);
                $('#get_phone2').val(data.shop_phone);
                $('#get_address2').val(data.shop_address);
                }
            });
            // end of ajax call
        });
    });
</script> --}}
