@extends('layouts.master')

@section('content')

    <!-- Breadcrumb -->
    <nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item"><a href="#">Page</a></li>
            <li class="breadcrumb-item active" aria-current="page">ทะเบียนลูกค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-md-people"></i></span>ทะเบียนลูกค้า (API)</h4>
            </div>
            <div class="d-flex">
            {{-- <button type="button" class="btn btn-teal btn-sm btn-rounded px-3" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button> --}}
            </div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">ตารางทะเบียนลูกค้า</h5>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="hk-pg-header mb-10">
                                    <div>
                                    </div>
                                    <div class="col-sm-12 col-md-9">
                                        <!-- ------ -->
                                        <span class="form-inline pull-right pull-sm-center">
                                            <select class="form-control custom-select form-control-sm" style="margin-left:5px; margin-right:5px;">
                                                <option selected>เลือกจังหวัด</option>
                                                <option value="1">กรุงเทพมหานคร</option>
                                                <option value="2">เชียงใหม่</option>
                                                <option value="3">สงขลา</option>
                                                <option value="3">ชัยภูมิ</option>
                                                <option value="3">ปราจีนบุรี</option>
                                            </select>

                                            <select class="form-control custom-select form-control-sm" style="margin-left:5px; margin-right:5px;">
                                                <option selected>เลือกอำเภอ</option>
                                            </select>

                                            <select class="form-control custom-select form-control-sm" style="margin-left:5px; margin-right:5px;">
                                                <option selected>เลือกตำบล</option>
                                            </select>

                                            <button style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm">ค้นหา</button>

                                        </span>
                                        <!-- ------ -->
                                    </div>
                                </div>
                                <div id="table_list" class="table-responsive col-md-12">
                                    <table id="datable_1" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;">#</th>
                                                <th style="font-weight: bold;">ชื่อร้าน</th>
                                                <th style="font-weight: bold;">ที่อยู่</th>
                                                <th style="font-weight: bold;">จำนวนวันสำคัญ<br />ในเดือน (วัน)</th>
                                                <th style="font-weight: bold;">จำนวนวันสำคัญ<br />รวม (วัน)</th>
                                                <th style="font-weight: bold;">จำนวนเป้าที่ซื้อในปี</th>
                                                <th style="font-weight: bold;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                            @php 
                                                @$row = count($customer_api)
                                            @endphp

                                            @foreach ($customer_api as $key => $value)
                                                <tr>
                                                    <td>{{ $customer_api[$key]['identify'] }}</td>
                                                    <td>{{ $customer_api[$key]['shopname'] }}</td>
                                                    <td>{{ $customer_api[$key]['address'] }}</td>
                                                    <td>{{ $customer_api[$key]['InMonthDays'] }}</td>
                                                    <td>{{ $customer_api[$key]['TotalDays'] }}</td>
                                                    <td>{{ $customer_api[$key]['TotalCampaign'] }}</td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="btn btn-icon btn-success mr-10">
                                                        <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                    </td>
                                                
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- /Row -->
    </div>
    <!-- /Container -->
@endsection

@section('footer')
    @include('layouts.footer')

    <script>
        $( document ).ready(function() {
            // api_fetch_customer_all();
        });

        function api_login(){
            let username = "apiuser";
            let password = "testapi";
            return Promise.resolve($.ajax({
                method: 'POST',
                url: 'http://49.0.64.92:8020/api/auth/login',
                data:{ username:username, password:password},
                datatype: 'json',
            }));
        };  

        async function api_fetch_customer_all(){
            
            let data_login = await api_login();
            let api_token = data_login.data[0].access_token
            // console.log(api_token);
            $('#table_body').children().remove().end();
            $.ajax({
                method: 'GET',
                // url: 'http://49.0.64.92:8020/api/v1/customers/00006/?token='+api_token,
                url: 'http://49.0.64.92:8020/api/v1/customers/00006',
                data:{ token:api_token },
                datatype: 'json',
                success: function(response){
                    if(response.code == 200){
                        console.log(response.data);
                        let content = `
                            <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="font-weight: bold;">#</th>
                                        <th style="font-weight: bold;">รูปภาพ</th>
                                        <th style="font-weight: bold;">ชื่อร้าน</th>
                                        <th style="font-weight: bold;">ที่อยู่</th>
                                        <!-- <th style="font-weight: bold;">ชื่อผู้ติดต่อ</th>
                                        <th style="font-weight: bold;">เบอร์โทรศัพท์</th> -->
                                    </tr>
                                </thead>
                                <tbody id="table_body">`;
                                    $.each(response.data, function(key, value){
                                        content +=  `
                                            <tr>
                                                <td>${value.identify}</td>
                                                <td></td>
                                                <td>${value.title} ${value.name}</td>
                                                <td>${value.address1} ${value.adrress2}</td>
                                            </tr>`;
                                    });
                        content += `</tbody>
                            </table>`;
                        $('#table_list').append(content);
                    }
                }
            });
        }

    </script>

@endsection

