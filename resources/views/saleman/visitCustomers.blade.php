@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">เข้าพบลูกค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                                data-feather="briefcase"></i></span></span>ตารางข้อมูลเข้าพบลูกค้า</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge02"> + เพิ่มใหม่ </button>
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-3">
                            <h5 class="hk-sec-title">ตารางข้อมูลเข้าพบลูกค้า</h5>
                        </div>
                        <div class="col-sm-12 col-md-9">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    <div class="d-flex">
                                        <input type="text" name="" id="" class="form-control form-control-sm" placeholder="ค้นหา">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อร้าน</th>
                                                <th>วันที่</th>
                                                <th>สถานะ</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list_visit as $key => $value)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$value->shop_name}}</td>
                                                <td>{{$value->customer_visit_date}}</td>
                                                <td><span class="badge badge-soft-success mt-15 mr-10" style="font-weight: bold; font-size: 12px;">Finished</span></td>
                                                <td>
                                                    <div class="button-list">
                                                        <button class="btn btn-icon btn-indigo mr-10" data-toggle="modal" data-target="#exampleModalLarge01" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-in" style="width:18px;"></i></span></button>
                                                        <button class="btn btn-icon btn-pumpkin mr-10" data-toggle="modal" data-target="#exampleModalLarge01" onclick="getLocation()">
                                                            <span class="btn-icon-wrap"><i data-feather="log-out" style="width:18px;"></i></span></button>
                                                        <button class="btn btn-icon btn-warning mr-10" onclick="edit_modal({{ $value->id }})" data-toggle="modal" data-target="#editCustomerVisit">
                                                            <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        <a href="{{url('delete_visit', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
                                                            <span class="btn-icon-wrap"><i data-feather="trash-2"></i></span></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>
    <!-- /Row -->
    </div>
    <!-- /Container -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLarge02" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge02"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มข้อมูลการเยี่ยมลูกค้า</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('create_visit') }}" method="post" enctype="multipart/form-data">
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
                        <input type="hidden" name="shop_id" id="get_id">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="firstName">ผู้ติดต่อ</label>
                                <input class="form-control" id="get_contact_name" type="text" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="firstName">เบอร์โทรศัพท์</label>
                                <input class="form-control" id="get_phone" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">ที่อยู่ร้าน</label>
                            <textarea class="form-control" id="get_address" cols="30" rows="5" placeholder="" value=""
                                type="text" readonly> </textarea>
                        </div>
                        <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="firstName">วันที่</label>
                            <input class="form-control" type="date" name="date" min="<?= date('Y-m-d') ?>" required/>
                        </div>
                        </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

     <!-- Modal -->
     <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Check-in 2 Check-out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mt-20 text-center">
                        <button type="button" class="btn btn-primary" onclick="getLocation()">GetLocation</button>
                        <p id="demo" class="mt-5"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Edit -->
     <div class="modal fade" id="editCustomerVisit" tabindex="-1" role="dialog" aria-labelledby="editCustomerVisit"
     aria-hidden="true">
     @include('saleman.visitCustomers_edit')
 </div>

    <script>
        $(document).ready(function() {

            $(".select2").select2({
                placeholder: 'กรุณาเลือกชื่อร้านค้า'
            });

            $('#searchShop').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "searchShop",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        // $('#search_list').html(data);
                    $('#get_id').val(data.id);
                    $('#get_contact_name').val(data.contact_name);
                    $('#get_phone').val(data.shop_phone);
                    $('#get_address').val(data.shop_address);
                    }
                });
                // end of ajax call
            });

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
                        $('#get_id').val(response.id);
                        $('#get_contact_name').val(response.contact_name);
                        $('#get_phone').val(response.shop_phone);
                        $('#get_address').val(response.shop_address);
                    },
                    error: function(response){
                        console.log("error");
                        console.log(response);
                    }
                });
            });


        });

    </script>

    <script>


        var x = document.getElementById("demo");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
        }

        function showError(error){
            switch(error.code){
                case error.PERMISSION_DENIED:
                    x.innerHTML="User denied the request for Geolocation."
                    reak;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML="Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML="The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML="An unknown error occurred."
                    break;
            }
        }

    </script>
@endsection
