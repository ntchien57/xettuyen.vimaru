@extends('layout')
@section('title', 'VIMARU - Đăng ký xét tuyển')


@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Đăng ký xét tuyển</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Đăng ký xét tuyển
                        </li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">KẾT QUẢ THI TỐT NGHIỆP THPT (Năm 2025)</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Số báo danh THPT<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Toán<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Lý<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Hóa<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Văn<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>
                             <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Sử<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Địa<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Anh<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Tin<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder=""
                                        class="form-control "
                                        value="">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary" type="submit">Lưu thông tin</button>
                </div>
                <!-- /.card-body -->
            </form>
        </div>
    </div>
    <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection

@section('script')


    <script>
        $(document).ready(function() {
            $('#tinh-select, #truong-select').select2({
                placeholder: 'Chọn...',
                width: '100%'
            });

            // Lấy danh sách tỉnh
            $(document).ready(function() {
                $.getJSON('https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json',
                    function(data) {
                        $.each(data, function(key, value) {
                            $('#tinh-select').append($('<option>', {
                                value: value.name,
                                text: value.name
                            }));
                        });
                    });
            });

            // Khi chọn tỉnh thì load trường
            $('#tinh-select').on('change', function() {
                const tinh = $(this).val();
                $('#truong-select').empty().append('<option value="">-- Chọn trường THPT --</option>');

                if (tinh) {
                    fetch(`https://api.daihocapi.com/api/truong-thpt?tinh=${encodeURIComponent(tinh)}`)
                        .then(res => res.json())
                        .then(truong => {
                            truong.forEach(t => {
                                $('#truong-select').append(
                                    `<option value="${t.ten}">${t.ten}</option>`);
                            });
                            $('#truong-select').trigger('change.select2');
                        });
                }
            });
        });
    </script>



@endsection
