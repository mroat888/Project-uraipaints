<div class="table-responsive table-color col-md-12">
    <table id="datable_1" class="table table-hover">
        <thead>
            <tr>
                <th style="font-weight: bold;">#</th>
                <th style="font-weight: bold;">รูปภาพ</th>
                <th style="font-weight: bold;">ชื่อร้าน</th>
                <th style="font-weight: bold;">ที่อยู่</th>
                <th style="font-weight: bold;">ชื่อผู้ติดต่อ</th>
                <th style="font-weight: bold;">เบอร์โทรศัพท์</th>
                <th style="font-weight: bold;">สถานะลูกค้า</th>
                <th style="font-weight: bold;" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer_shops as $key => $shop)
            <tr>
                <td>{{$key + 1}}</td>
                <td>
                    <div class="media-img-wrap">
                        <div class="avatar avatar-sm">
                            @if ($shop->shop_profile_image)
                            <img src="{{ isset($shop->shop_profile_image) ? asset('/public/upload/CustomerImage/' . $shop->shop_profile_image) : '' }}"
                            alt="{{ $shop->shop_name }}" class="avatar-img">

                            @else
                            <img src="{{ asset('/public/images/people-33.png')}}" alt="" class="avatar-img">
                            @endif

                        </div>
                    </div>
                </td>
                <td>{{ $shop->shop_name }}</td>
                <td>{{ $shop->PROVINCE_NAME }}</td>
                    @php
                        $customer_contact_name = "";
                        $customer_contact_phone = "";
                        foreach($customer_contacts as $value){
                            if($value->customer_shop_id == $shop->id){
                                if(!empty($value->customer_contact_name)){
                                    $customer_contact_name = $value->customer_contact_name;
                                }
                                if(!empty($value->customer_contact_phone)){
                                    $customer_contact_phone = $value->customer_contact_phone;
                                }
                                break;
                            }
                        }
                    @endphp
                <td>{{ $customer_contact_name }}</td>
                <td>{{ $customer_contact_phone }}</td>
                <td>
                    @if($shop->shop_status == 1)
                        <span class="badge badge-soft-success" style="font-size: 12px;">สำเร็จ</span>
                    @elseif($shop->saleplan_shop_aprove_status == 3)
                        <span class="badge badge-soft-purple" style="font-size: 12px;">ไม่ผ่านอนุมัติ</span>
                    @else
                        @if(!is_null($shop->cust_result_status))
                            @if($shop->cust_result_status == 2) <!-- สนใจ	 -->
                                <span class="badge badge-soft-orange" style="font-size: 12px;">สนใจ</span>
                            @elseif($shop->cust_result_status == 1) <!-- รอตัดสินใจ -->
                                <span class="badge badge-soft-primary" style="font-size: 12px;">รอตัดสินใจ</span>
                            @elseif($shop->cust_result_status == 0) <!-- ไม่สนใจ  -->
                                <span class="badge badge-soft-danger" style="font-size: 12px;">ไม่สนใจ</span>
                            @endif
                        @else
                            -
                        @endif
                    @endif
                </td>
                <td>
                    <div class="button-list">
                        @php 

                            //--- เช็คสถานะ User มาจากระบบไหน 

                            $btn_edit_hide = "display:none";
                            $btn_comment_hide = "display:none";
                            $url_comment = "";
                            
                            if($user_level == "seller"){ //-- ถ้ามาจากระบบ sale และเป็นลูกค้าใหม่
                                if($shop->shop_status == "0"){
                                    $btn_edit_hide = "display:block";
                                }
                            }

                            if($user_level == "header"){ //-- ถ้ามาจากระบบ header และเป็นลูกค้ารอตัดสินใจ
                                if($shop->cust_result_status == "1" && $shop->shop_status == "0"){
                                    $btn_comment_hide = "display:block";
                                    $url_comment = "head/comment_customer_new_except";
                                }
                            }
                        @endphp
                        <button class="btn btn-icon btn-edit btn_editshop" value="{{ $shop->id }}" style="{{ $btn_edit_hide }}">
                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-create"></i></h4></button>
                        
                        <a href="{{ url($url_customer_detail, $shop->id) }}" class="btn btn-icon btn-purple">
                            <h4 class="btn-icon-wrap" style="color: white;"><i class="ion ion-md-pie"></i></h4></a>

                        <a href="{{ url($url_comment, [$shop->id, $shop->customer_shops_saleplan_id, $shop->monthly_plans_id]) }}" 
                            class="btn btn-icon btn-info mr-10" style="{{ $btn_comment_hide }}">
                            <h4 class="btn-icon-wrap" style="color: white;">
                                <span class="material-icons">question_answer</span>
                            </h4>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
