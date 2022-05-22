<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light bg-transparent">
            <li class="breadcrumb-item active">ค้นหารายการสินค้า</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <div class="hk-pg-header mb-10">
                        <div class="topichead-bgred">ค้นหารายการสินค้า</div>
                    </div>
                    <div class="row mb-2">
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <!-- ------ -->
                            <span>
                                <div class="form-group col-md-12">
                                    <select name="sel_pdglists" id="sel_pdglists" class="form-control sel_pdglists select2" required>
                                        <option value="">--ค้นหารายการสินค้า--</option>
                                        
                                        @foreach($pdglists['data'] as $value)
                                            <option value="{{ $value['identify'] }}">{{ $value['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </span>
                            <!-- ------ -->
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <span class="form-inline pull-right pull-sm-center">
                                        <select name="province" id="province" class="form-control province" style="margin-left:5px; margin-right:5px;">
                                            <option value="" selected>เลือกจังหวัด</option>
                                        </select>

                                        <select name="amphur" id="amphur" class="form-control amphur" style="margin-left:5px; margin-right:5px;">
                                            <option value="" selected>เลือกอำเภอ</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="col-sm" id="table_customer">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12 col-md-12">
                            <div class="card">
                                <div class="hk-pg-header mb-10">
                                    <div class="topichead-bggreen">ข้อมูลรายการสินค้า</div>
                                </div>
                                {{-- <div class="card-header">
                                    ข้อมูลรายการสินค้า
                                </div> --}}
                                <div class="card-body">
                                    <div class="col-sm" id="table_product">

                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>


                </section>
            </div>
        </div>


    </div>
    <!-- /Container -->
