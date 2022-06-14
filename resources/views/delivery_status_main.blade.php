
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="topic-secondgery">รายการสถานะจัดส่ง</div>
                    <div class="row">
                        <div class="col-sm" style="margin-top: 20px;">
                            <div class="table-responsive col-md-12 table-color">
                                <table id="datable_1" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อร้านค้า</th>
                                            <th>จังหวัด</th>
                                            <th>เลขที่บิล</th>
                                            <th>จำนวนชิ้น</th>
                                            <th>ประเภทการจัดส่ง</th>
                                            <th>สถานะจัดส่ง</th>
                                            <th>วันที่จัดส่ง</th>
                                            <th>หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($delivery_api != '')
                                        @foreach ($delivery_api as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $delivery_api[$key]['shop_name'] }}</td>
                                            <td>{{ $delivery_api[$key]['province'] }}</td>
                                            <td>{{ $delivery_api[$key]['invonce_no'] }}</td>
                                            <td>{{ $delivery_api[$key]['total_quan'] }}</td>
                                            <td>{{ $delivery_api[$key]['delivery_type'] }}</td>
                                            <td>{{ $delivery_api[$key]['delivery_status'] }}</td>
                                            <td>{{ $delivery_api[$key]['delivery_date'] }}</td>
                                            <td>{{ $delivery_api[$key]['remark'] }}</td>
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

