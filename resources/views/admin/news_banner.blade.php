@extends('layouts.masterAdmin')

@section('content')
 <!-- Breadcrumb -->
 <nav class="hk-breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-light bg-transparent">
        <li class="breadcrumb-item active">ข่าวสาร</li>
        {{-- <li class="breadcrumb-item active" aria-current="page">ปฎิทินกิจกรรม</li> --}}
    </ol>
</nav>
<!-- /Breadcrumb -->

    <!-- Container -->
    <div class="container-fluid px-xxl-65 px-xl-20">
        <!-- Title -->
        <div class="hk-pg-header mb-10">
            <div>
                <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i
                    data-feather="image"></i></span></span>เพิ่มแบนเนอร์</h4>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-teal btn-sm btn-rounded px-3 mr-10" data-toggle="modal" data-target="#exampleModalLarge01"> + เพิ่มใหม่ </button>

                <a href="{{ url('admin/news')}}" type="button" class="btn btn-secondary btn-sm btn-rounded px-3 mr-10"> ย้อนกลับ </a>
            </div>
        </div>
        <!-- /Title -->

            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">ตารางรูปภาพแบนเนอร์</h5>
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <div class="hk-pg-header mb-10">
                                <div>
                                </div>
                            </div>
                            <div class="table-responsive col-md-12">
                                <table id="datable_1" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รูปภาพ</th>
                                        <th>รายละเอียด</th>
                                        <th>วันที่แจ้งเตือน</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_banner as $key => $value)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><img src="{{ isset($value->banner) ? asset('public/upload/NewsBanner/' . $value->banner) : '' }}" width="200"></td>
                                        <td>{{$value->detail}}</td>
                                        <td>{{$value->date}}</td>
                                        <td>
                                            <div class="button-list">
                                                {{-- <button class="btn btn-icon btn-primary mr-10">
                                                    <span class="btn-icon-wrap"><i data-feather="feather"></i></span></button> --}}
                                                    <button onclick="edit_modal({{ $value->id }})"
                                                        class="btn btn-icon btn-warning mr-10" data-toggle="modal" data-target="#editBanner">
                                                        <span class="btn-icon-wrap"><i data-feather="edit"></i></span></button>
                                                        <a href="{{url('admin/delete_banner', $value->id)}}" class="btn btn-icon btn-danger mr-10" onclick="return confirm('ต้องการลบข้อมูลนี้ใช่หรือไม่ ?')">
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
                </div>
            </section>
    </div>
    <!-- /Container -->

     <!-- Modal -->
     <div class="modal fade" id="exampleModalLarge01" tabindex="-1" role="dialog" aria-labelledby="exampleModalLarge01" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มเพิ่มแบนเนอร์ข่าวสาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/create_newsBanner') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="detail">รายละเอียดเกี่ยวกับแบนเนอร์</label>
                        <input class="form-control" type="text" name="detail" required>
                    </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="banner">รูปภาพ</label>
                                <input class="form-control" type="file" name="banner" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="banner">วันที่</label>
                                <input class="form-control" type="date" name="date" required>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="username">Link URL</label>
                            <input class="form-control" placeholder="URL" value="" type="text">
                        </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
            </div>
        </div>
    </div>

     <!-- Modal Edit -->
     <div class="modal fade" id="editBanner" tabindex="-1" role="dialog" aria-labelledby="editBanner" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ฟอร์มแก้ไขแบนเนอร์ข่าวสาร</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('admin/update_banner') }}" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="detail">รายละเอียดเกี่ยวกับแบนเนอร์</label>
                        <input class="form-control" type="text" name="detail" id="get_detail" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="banner">รูปภาพ</label>
                            <input class="form-control" type="file" id="get_image" name="banner">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="banner">วันที่</label>
                            <input class="form-control" type="date" id="get_date" name="date" required>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label for="username">Link URL</label>
                        <input class="form-control" placeholder="URL" value="" type="text">
                    </div> --}}
                        <input type="hidden" name="id" id="get_id">
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
        //Edit
        function edit_modal(id) {
            $.ajax({
                type: "GET",
                url: "{!! url('admin/edit_banner/"+id+"') !!}",
                dataType: "JSON",
                async: false,
                success: function(data) {
                    $('#get_id').val(data.dataEdit.id);
                    $('#get_date').val(data.dataEdit.date);
                    $('#get_detail').val(data.dataEdit.detail);
                    $('#get_image').val(data.dataEdit.banner);


                    $('#editBanner').modal('toggle');
                }
            });
        }
    </script>
@endsection
