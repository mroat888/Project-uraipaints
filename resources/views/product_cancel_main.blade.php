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
                                            @if(isset($groups) && !is_null($groups))
                                                @foreach ($groups as $key => $value)
                                                    <option value="{{$groups[$key]['id']}}">{{$groups[$key]['group_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        <select name="brand" class="form-control" aria-label=".form-select-lg example">
                                            <option value="" selected>ชื่อตราสินค้า</option>
                                            @if(isset($brands) && !is_null($brands))
                                                @foreach ($brands as $key => $value)
                                                    <option value="{{$brands[$key]['id']}}">{{$brands[$key]['brand_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type="submit" class="btn btn-green btn-sm ml-2">ค้นหา</button>
                                </form>
                                </span>

                            </div>
                            <div class="row">
                                @foreach ($product_cancel as $value)
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    @if (Auth::user()->status == 1)
                                    <a href="{{url('view_product_cancel_detail', $value->id)}}">

                                    @elseif (Auth::user()->status == 2)
                                    <a href="{{url('lead/view_product_cancel_detail', $value->id)}}">

                                        @elseif (Auth::user()->status == 3)
                                        <a href="{{url('head/view_product_cancel_detail', $value->id)}}">
                                    @endif
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

    <style>
        .img_1 {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px;
        }
    </style>


