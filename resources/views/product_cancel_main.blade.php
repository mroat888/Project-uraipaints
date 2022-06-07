            <section class="hk-sec-wrapper">
                <div class="topic-secondgery">รายการสินค้ายกเลิก</div>
                <div class="row">
                    <div class="col-sm">
                            <div class="hk-pg-header" style="margin-bottom: 30px;">
                                <div>
                                </div>
                                <span class="form-inline pull-right">
                                    @if (Auth::user()->status == 1)
                                    <form action="{{url('search-product_cancel')}}" method="POST" enctype="multipart/form-data">

                                    @elseif (Auth::user()->status == 2)
                                    <form action="{{url('lead/search-product_cancel')}}" method="POST" enctype="multipart/form-data">

                                        @elseif (Auth::user()->status == 3)
                                        <form action="{{url('head/search-product_cancel')}}" method="POST" enctype="multipart/form-data">
                                    @endif

                                        @csrf
                                        <select name="category" class="form-control" aria-label=".form-select-lg example">
                                            <option value="" selected>หมวดสินค้า</option>
                                            @foreach ($groups as $key => $value)
                                                <option value="{{$groups[$key]['id']}}">{{$groups[$key]['group_name']}}</option>
                                            @endforeach
                                        </select>

                                        <select name="brand" class="form-control" aria-label=".form-select-lg example">
                                            <option value="" selected>ชื่อตราสินค้า</option>
                                            @foreach ($brands as $key => $value)
                                                <option value="{{$brands[$key]['id']}}">{{$brands[$key]['brand_name']}}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-green btn-sm ml-2">ค้นหา</button>
                                </form>
                                </span>

                            </div>
                            <div class="row">
                                @foreach ($product_cancel as $value)
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <a href="#" onclick="view_modal({{ $value->id }})" data-toggle="modal" data-target="#viewProductCancel">
                                    <div class="card mb-20">
                                        <center>
                                            <img class="" src="{{ isset($value->image) ? asset('public/upload/ProductCancel/' . $value->image) : '' }}" alt="{{ $value->image}}" width="250">
                                        </center>
                                        <div class="card-body">
                                            <p class="card-text" style="color: black;">{{$value->description}}</p>
                                        </div>
                                    </div>
                                </a>
                                </div>
                                @endforeach

                            </div>
                    </div>
                </div>
            </section>
    <!-- /Container -->


    <div class="modal fade" id="viewProductCancel" tabindex="-1" role="dialog" aria-labelledby="viewProductCancel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">รายละเอียดสินค้ายกเลิก</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="category" style="font-weight: bold;">หมวด : </label>
                                <span id="view_category_id"></span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="date" style="font-weight: bold;">วันที่อัพเดตล่าสุด : </label>
                                <span id="view_date"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="brand" style="font-weight: bold;">ตราสินค้า : </label>
                                <span id="view_brand_id"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" style="font-weight: bold;">รายละเอียด : </label>
                            <span id="view_description"></span>
                        </div>
                        <div class="form-group">
                            <label for="url" style="font-weight: bold;">Link URL : </label>
                            <span id="view_url"></span>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="image" style="font-weight: bold;">รูปภาพ</label>
                        </div>
                        <div>
                            <div class="form-group">
                                <center>
                                <span id="view_img_show" class=""></span>
                                </center>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .img_1 {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px;
        }
    </style>


