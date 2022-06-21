<!-- Breadcrumb -->
<nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item"><a href="#">Page</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายงานยอดขายสินค้าใหม่</li>
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div class="topichead-bgred"><i data-feather="file-text"></i> รายงานยอดขายสินค้าใหม่</div>
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col-sm-12 col-md-6">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <!-- ------ -->
                            <form action="{{ url('manager/data_report_product-new/search') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <span class="form-inline pull-right pull-sm-center">
                                    <select name="year_search" id="year_form_search" class="form-control" style="margin-left:5px; margin-right:5px;">
                                        @php
                                            $year_now = date("Y");
                                            $year_back = $year_now - 1;
                                            $year_form_search = array($year_now, $year_back);
                                        @endphp
                                        @if(isset($year_form_search))
                                            @foreach($year_form_search as $value_year)
                                                @php
                                                    $year_thai = $value_year+543;
                                                @endphp
                                                @if((isset($year_search)) && ($year_search == $value_year))
                                                    <option value="{{ $value_year }}" selected>{{ $year_thai }}</option>
                                                @else
                                                    <option value="{{ $value_year }}">{{ $year_thai }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>

                                    <button style="margin-left:5px; margin-right:5px;" class="btn btn-green">ค้นหา</button>
                                </span>
                            </form>
                            <!-- ------ -->
                        </div>
                    </div>

                    @include('shareData_union.report_product_new_table')

                </section>
            </div>

        </div>
        <!-- /Row -->
    </div>
