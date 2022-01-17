<?php $objective = App\ObjectiveSaleplan::all();

$customer_shops = DB::table('customer_shops')
->join('customer_contacts', 'customer_shops.id', '=', 'customer_contacts.customer_shop_id')
        ->whereIn('customer_shops.shop_status', [0, 1]) // ดึงเฉพาะ ลูกค้าเป้าหมายและทะเบียนลูกค้า
        ->where('customer_shops.created_by',Auth::user()->id)
        ->orderby('customer_shops.shop_name','asc')
        ->select(
                'customer_contacts.customer_contact_name',
                'customer_contacts.customer_contact_phone',
                'customer_shops.*'
                )
        ->get();

        ?>

<!-- Modal -->
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มข้อมูลการเยี่ยมลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_insert_visit" enctype="multipart/form-data">
                    {{-- <form action="{{ url('create_visit') }}" method="post" enctype="multipart/form-data"> --}}
                    @csrf
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ค้นหาชื่อร้าน</label>
                                <!-- <input class="form-control" id="searchShop" placeholder="" value="" type="text"> -->
                                <select name="sel_searchShop" id="sel_searchShop" class="form-control custom-select select2">
                                    <option value="" selected disabled>กรุณาเลือกชื่อร้านค้า</option>
                                    @foreach ($customer_shops as $value)
                                    <option value="{{$value->id}}">{{$value->shop_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="shop_id" id="visit_id">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ผู้ติดต่อ</label>
                                <input class="form-control" id="visit_contact_name" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">เบอร์โทรศัพท์</label>
                                <input class="form-control" id="visit_phone" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">ที่อยู่ร้าน</label>
                            <textarea class="form-control" id="visit_address" cols="30" rows="5" placeholder="" value=""
                                type="text" readonly> </textarea>
                        </div>
                        {{-- <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">วันที่</label> --}}
                            <input class="form-control" type="hidden" name="date" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required/>
                        {{-- </div>
                        </div> --}}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="username">รายการนำเสนอ</label>
                                <select class="form-control custom-select" name="product" required>
                                    <option selected>กรุณาเลือก</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="objective">วัตถุประสงค์</label>
                                <select class="form-control custom-select" name="visit_objective" required>
                                    <option selected>กรุณาเลือก</option>
                                    @foreach ($objective as $value)
                                    <option value="{{$value->id}}">{{$value->masobj_title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$monthly_plan_id}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
        $("#form_insert_visit").on("submit", function (e) {
            e.preventDefault();
            // var formData = $(this).serialize();
            var formData = new FormData(this);
            //console.log(formData);
            $.ajax({
                type:'POST',
                url: '{{ url("create_visit") }}',
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
                    $("#addCustomer").modal('hide');
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
        $(document).ready(function() {


            $("#sel_searchShop").on("change", function (e) {
                //alert('ssdsd');
                e.preventDefault();
                let shop_id = $(this).val();
                console.log(shop_id);
                $.ajax({
                    method: 'GET',
                    url: '{{ url("/fetch_customer_shops_visit") }}/'+shop_id,
                    datatype: 'json',
                    success: function(response){
                        console.log(response)
                        $('#visit_id').val(response.id);
                        $('#visit_contact_name').val(response.customer_contact_name);
                        $('#visit_phone').val(response.customer_contact_phone);
                        $('#visit_address').val(response.shop_address);
                    },
                    error: function(response){
                        console.log("error");
                        console.log(response);
                    }
                });
            });


        });

    </script>
