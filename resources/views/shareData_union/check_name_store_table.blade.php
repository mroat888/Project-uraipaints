<!-- Row -->
<div class="row">
    <div class="col-xl-12">
        <section class="hk-sec-wrapper">
            <div class="row mb-2">
                <div class="col-sm-12 col-md-3">
                    <h5 class="hk-sec-title">ตารางข้อมูลรายชื่อร้านค้า</h5>
                </div>

            </div>

            <div class="row">
                <div class="col-sm">
                    <div class="table-wrap">
                        <div class="hk-pg-header mb-10">
                            <div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <!-- ------ -->
                                <form action="{{ url($action_search) }}" method="post">
                                    @csrf
                                    <span class="form-inline pull-right pull-sm-center">
                                        <select name="province" id="province" class="form-control province" style="margin-left:5px; margin-right:5px;">
                                            <option value="" selected>เลือกจังหวัด</option>
                                            @if(isset($provinces) && !is_null($provinces))
                                                @foreach($provinces as $key => $value)
                                                    @if(!empty($value['identify']))
                                                        <option value="{{ $value['identify'] }}">{{ $value['name_thai'] }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                            
                                        </select>

                                        <select name="amphur" id="amphur" class="form-control amphur" style="margin-left:5px; margin-right:5px;">
                                            <option value="" selected>เลือกอำเภอ</option>
                                        </select>
                                        <!-- จำนวนเป้า
                                        <input type="number" name="campaign_count" style="width:80px;" class="form-control amphur"> -->

                                        <button id="btn_search" style="margin-left:5px; margin-right:5px;" class="btn btn-teal btn-sm">ค้นหา</button>
                                    </span>
                                </form>
                                <!-- ------ -->
                            </div>
                        </div>
                        <div id="table_list" class="table-responsive col-md-12">
                            <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="font-weight: bold;">#</th>
                                        <th style="font-weight: bold;">รูปภาพ</th>
                                        <th style="font-weight: bold;">รหัสร้าน</th>
                                        <th style="font-weight: bold;">ชื่อร้าน</th>
                                        <th style="font-weight: bold;">ที่อยู่</th>
                                        <th style="font-weight: bold;">เบอร์โทรศัพท์</th>
                                        <th style="font-weight: bold;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    @php 
                                        $number = 0;
                                    @endphp

                                    @if(isset($customer_api) && !is_null($customer_api))
                                        @foreach ($customer_api as $key => $customer)
                                            <tr>
                                                <td>{{ ++$number }}</td>
                                                <td>
                                                    @if(isset($customer['image_url']) && !is_null($customer['image_url']))
                                                        <img src="{{ $customer['image_url'] }}" style="max-height:20px;">
                                                    @endif
                                                </td>
                                                <td>{{ $customer['identify'] }}</td>
                                                <td>{{ $customer['title'] }} {{ $customer['name'] }}</td>
                                                <td>{{ $customer['amphoe_name'] }}, {{ $customer['province_name'] }}</td>
                                                <td>{{ $customer['telephone'] }}, {{ $customer['mobile'] }}</td>
                                                <td>
                                                    @php
                                                        $pathurl = url($path_detail).'/'.$customer['identify'];
                                                    @endphp
                                                    <a href="{{ $pathurl }}" class="btn btn-icon btn-success mr-10">
                                                    <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
<!-- /Row -->