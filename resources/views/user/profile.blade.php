@extends('layout')
@section('title', 'VIMARU - Thông tin thí sinh')


@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Thông tin thí sinh</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Thông tin thí sinh
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
            <form>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">THÔNG TIN CHUNG</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập họ và tên" required>
                                    <span style="font-size: 12px">Họ và tên in hoa, có dấu</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Ngày sinh <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" placeholder="Nhập ngày sinh" required>
                                    <span style="font-size: 12px">Định dạng DD/MM/YYYY</span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Giới tính <span class="text-danger">*</span></label>
                                    <select class="form-control" name="" id="">
                                        <option>Chọn giới tính</option>
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                    </select>
                                </div>
                            </div>

                            @php
                                $dantoc = [
                                    'Kinh',
                                    'Tày',
                                    'Thái',
                                    'Mường',
                                    'Khmer',
                                    'Hoa',
                                    'Nùng',
                                    'H\'Mông',
                                    'Dao',
                                    'Gia-rai',
                                    'Ê-đê',
                                    'Ba-na',
                                    'Sán Chay',
                                    'Chăm',
                                    'Xê-đăng',
                                    'Sán Dìu',
                                    'Hrê',
                                    'Ra-glai',
                                    'Mnông',
                                    'Thổ',
                                    'Stiêng',
                                    'Khơ Mú',
                                    'Bru - Vân Kiều',
                                    'Cơ Ho',
                                    'Tà Ôi',
                                    'Giáy',
                                    'Cơ Tu',
                                    'Gié Triêng',
                                    'Mạ',
                                    'Co',
                                    'Chơ Ro',
                                    'Xinh Mun',
                                    'Hà Nhì',
                                    'Chu Ru',
                                    'Lào',
                                    'La Chí',
                                    'Phù Lá',
                                    'La Hủ',
                                    'Kháng',
                                    'Lự',
                                    'Lô Lô',
                                    'Chứt',
                                    'Mảng',
                                    'Pà Thẻn',
                                    'Co Lao',
                                    'Cống',
                                    'Bố Y',
                                    'Si La',
                                    'Pu Péo',
                                    'Brâu',
                                    'Ơ Đu',
                                    'Rơ Măm'
                                ];
                            @endphp

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Dân tộc <span class="text-danger">*</span></label>
                                    <select style="padding: 0.375rem 0.75rem !important;" class="form-control" name=""
                                        id="dantoc-select">
                                        <option>Chọn dân tộc</option>
                                        @foreach ($dantoc as $dt)
                                            <option value="{{ $dt }}">{{ $dt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Số Căn cước/CCCD <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập CCCD" required>
                                    <span style="font-size: 12px">Số Căn cước/Căn cước công dân đăng ký tài khoản</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Nơi sinh <span class="text-danger">*</span></label>
                                    <select class="form-control" name="" id="noisinh-select">
                                        <option>Chọn nơi sinh</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập Email" required>
                                    <span style="font-size: 12px">Email cá nhân đăng ký tài khoản
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập số điện thoại" required>
                                    <span style="font-size: 12px">Ưu tiên số điện thoại có đăng ký ZALO (Nếu có)</span>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Hình ảnh Căn cước/Căn cước công dân<span
                                            class="text-danger">*</span></label>
                                    <div
                                        class="text-center border border-dashed border-secondary rounded border-opacity-50">
                                        <img class="w-75" src="{{asset('assets/img/mat-truoc-cc.png')}}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">&nbsp;</label>
                                    <div
                                        class="text-center border border-dashed border-secondary rounded border-opacity-50">
                                        <img class="w-75" src="{{asset('assets/img/mat-truoc-cc.png')}}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group mb-3">
                                    <label class="fw-bold mb-2">&nbsp;</label>
                                    <label class="fw-bold mb-2 d-block">Mặt trước:</label>
                                    <input type="file" id="cccd_front" name="cccd_front" class="d-none" accept="image/*">
                                    <label for="cccd_front" class="btn btn-secondary btn-block">
                                        CHỌN HÌNH ẢNH CĂN CƯỚC MẶT TRƯỚC
                                    </label>
                                    <small id="cccd_front_name" class="text-muted ms-1"></small>
                                </div>

                                <div class="form-group">
                                    <label class="fw-bold mb-2 d-block">Mặt sau:</label>
                                    <input type="file" id="cccd_back" name="cccd_back" class="d-none" accept="image/*">
                                    <label for="cccd_back" class="btn btn-secondary btn-block">
                                        CHỌN HÌNH ẢNH CĂN CƯỚC MẶT SAU
                                    </label>
                                    <small id="cccd_back_name" class="text-muted ms-1"></small>
                                </div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Địa chỉ thường trú <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập địa chỉ thường trú" required>
                                    <span style="font-size: 12px">Số nhà, đường, xã/phường, huyện/quận, tỉnh/thành phố theo
                                        CCCD</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">THÔNG TIN TUYỂN SINH</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập họ và tên" required>
                                    <span style="font-size: 12px">Họ và tên in hoa, có dấu</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Ngày sinh <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" placeholder="Nhập ngày sinh" required>
                                    <span style="font-size: 12px">Định dạng DD/MM/YYYY</span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Giới tính <span class="text-danger">*</span></label>
                                    <select class="form-control" name="" id="">
                                        <option>Chọn giới tính</option>
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                    </select>
                                </div>
                            </div>

                            @php
                                $dantoc = [
                                    'Kinh',
                                    'Tày',
                                    'Thái',
                                    'Mường',
                                    'Khmer',
                                    'Hoa',
                                    'Nùng',
                                    'H\'Mông',
                                    'Dao',
                                    'Gia-rai',
                                    'Ê-đê',
                                    'Ba-na',
                                    'Sán Chay',
                                    'Chăm',
                                    'Xê-đăng',
                                    'Sán Dìu',
                                    'Hrê',
                                    'Ra-glai',
                                    'Mnông',
                                    'Thổ',
                                    'Stiêng',
                                    'Khơ Mú',
                                    'Bru - Vân Kiều',
                                    'Cơ Ho',
                                    'Tà Ôi',
                                    'Giáy',
                                    'Cơ Tu',
                                    'Gié Triêng',
                                    'Mạ',
                                    'Co',
                                    'Chơ Ro',
                                    'Xinh Mun',
                                    'Hà Nhì',
                                    'Chu Ru',
                                    'Lào',
                                    'La Chí',
                                    'Phù Lá',
                                    'La Hủ',
                                    'Kháng',
                                    'Lự',
                                    'Lô Lô',
                                    'Chứt',
                                    'Mảng',
                                    'Pà Thẻn',
                                    'Co Lao',
                                    'Cống',
                                    'Bố Y',
                                    'Si La',
                                    'Pu Péo',
                                    'Brâu',
                                    'Ơ Đu',
                                    'Rơ Măm'
                                ];
                            @endphp

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Dân tộc <span class="text-danger">*</span></label>
                                    <select style="padding: 0.375rem 0.75rem !important;" class="form-control" name=""
                                        id="dantoc-select">
                                        @foreach ($dantoc as $dt)
                                            <option>Chọn dân tộc</option>
                                            <option value="{{ $dt }}">{{ $dt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Thông tin học tập:
                                        <span class="text-danger">*</span></label> <br>
                                    <span style="font-size: 12px">Nhập đầy đủ thông tin học tập 03 năm THPT </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">&nbsp;</label>
                                    <br>
                                    <p class="fw-bold text-center">Lớp 10</p>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Tỉnh - Thành Phố <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="tinh-select" name="tinh" required>
                                        <option value="">-- Chọn tỉnh/thành --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Trường THPT <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="truong-select" name="truong" required>
                                        <option value="">-- Chọn trường THPT --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Học lực <span class="text-danger">*</span></label>
                                    <select class="form-control" name="" id="noisinh-select">
                                        <option>Chọn nơi sinh</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Hạnh kiểm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Nhập Email" required>

                                </div>
                            </div>
                        </div>
                    </div>
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
    {{--
    <script>
        $(document).ready(function () {
            $('#dantoc-select').select2({
                placeholder: "-- Chọn dân tộc --",
                allowClear: true,
                width: '100%'
            });
        });
    </script> --}}
    <script>
        $(document).ready(function () {
            $.getJSON('https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json', function (data) {
                $.each(data, function (key, value) {
                    $('#noisinh-select').append($('<option>', {
                        value: value.name,
                        text: value.name
                    }));
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#tinh-select, #truong-select').select2({ placeholder: 'Chọn...', width: '100%' });

            // Lấy danh sách tỉnh
            $(document).ready(function () {
                $.getJSON('https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json', function (data) {
                    $.each(data, function (key, value) {
                        $('#tinh-select').append($('<option>', {
                            value: value.name,
                            text: value.name
                        }));
                    });
                });
            });

            // Khi chọn tỉnh thì load trường
            $('#tinh-select').on('change', function () {
                const tinh = $(this).val();
                $('#truong-select').empty().append('<option value="">-- Chọn trường THPT --</option>');

                if (tinh) {
                    fetch(`https://api.daihocapi.com/api/truong-thpt?tinh=${encodeURIComponent(tinh)}`)
                        .then(res => res.json())
                        .then(truong => {
                            truong.forEach(t => {
                                $('#truong-select').append(`<option value="${t.ten}">${t.ten}</option>`);
                            });
                            $('#truong-select').trigger('change.select2');
                        });
                }
            });
        });
    </script>

@endsection