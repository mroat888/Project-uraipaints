 <!-- Modal -->>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขข้อมูลการเยี่ยมลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('update_customerVisit') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ค้นหาชื่อร้าน</label>
                                <!-- <input class="form-control" id="searchShop2" type="text"> -->
                                <select name="sel_searchShop2" id="sel_searchShop2" class="form-control custom-select select2">
                                    <option value="" selected disabled>กรุณาเลือกชื่อร้านค้า</option>
                                    @foreach ($customer_api as $key => $value)
                                        <option value="{{$customer_api[$key]['id']}}">{{$customer_api[$key]['shop_name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="shop_id" id="get_shop_id">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ผู้ติดต่อ</label>
                                <input class="form-control" id="get_contact_name2" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">เบอร์โทรศัพท์</label>
                                <input class="form-control" id="get_phone2" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">ที่อยู่ร้าน</label>
                            <textarea class="form-control" id="get_address2" cols="30" rows="5" placeholder="" value=""
                                type="text" readonly> </textarea>
                        </div>
                        <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">วันที่</label>
                            <input class="form-control" id="get_date" type="date" name="date" min="<?= date('Y-m-d') ?>" required/>
                        </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">รายการนำเสนอ</label>
                                <select class="form-control custom-select" id="get_product" name="product" required>
                                    <option selected>กรุณาเลือก</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="objective">วัตถุประสงค์</label>
                                <select class="form-control custom-select" id="get_objective" name="visit_objective" required>
                                    <option selected>กรุณาเลือก</option>
                                    @foreach ($objective as $value)
                                    <option value="{{$value->id}}">{{$value->masobj_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id" id="get_id2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
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
                    url: "{!! url('edit_customerVisit/"+id+"') !!}",
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        $('#get_id2').val(data.visit.id);
                        $('#get_shop_id').val(data.visit.shop_id);
                        $('#get_contact_name2').val(data.visit.contact_name);
                        $('#get_phone2').val(data.visit.shop_phone);
                        $('#get_address2').val(data.visit.shop_address);
                        $('#get_date').val(data.visit.customer_visit_date);
                        $('#get_product').val(data.visit.customer_visit_tags);
                        $('#get_objective').val(data.visit.customer_visit_objective);

                        $('#editCustomerVisit').modal('toggle');
                    }
                });
            }
        </script>

    <script>
        $(document).ready(function() {
             
            $("#sel_searchShop2").on("change", function (e) { 
                e.preventDefault();
                let shop_id = $(this).val();
                console.log(shop_id);
                $.ajax({
                    method: 'GET',
                    url: '{{ url("/fetch_customer_shops_visit") }}/'+shop_id,
                    datatype: 'json',
                    success: function(response){
                        console.log(response)
                        $('#get_id2').val(response.id);
                        $('#get_contact_name2').val(response.contact_name);
                        $('#get_phone2').val(response.shop_phone);
                        $('#get_address2').val(response.shop_address);
                    },
                    error: function(response){
                        console.log("error");
                        console.log(response);
                    }
                });
            });

            $('#searchShop2').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "searchShop",
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
    </script>
