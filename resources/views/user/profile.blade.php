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
            <form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                                    <input type="text" name="full_name" class="form-control" placeholder="Nhập họ và tên"
                                        value="{{ old('full_name', $profile->full_name) }}" required>
                                    <span style="font-size: 12px">Họ và tên in hoa, có dấu</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Ngày sinh <span class="text-danger">*</span></label>
                                    <input name="dob" type="date" class="form-control"
                                        value="{{ old('dob', $profile->dob) }}" placeholder="Nhập ngày sinh" required>
                                    <span style="font-size: 12px">Định dạng DD/MM/YYYY</span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Giới tính <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender" id="">
                                        <option>Chọn giới tính</option>
                                        <option value="male" @selected(old('gender', $profile->gender) == 'male')>Nam</option>
                                        <option value="female" @selected(old('gender', $profile->gender) == 'female')>Nữ</option>
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
                                    <select style="padding: 0.375rem 0.75rem !important;" class="form-control"
                                        name="ethnicity" id="dantoc-select">
                                        <option>Chọn dân tộc</option>
                                        @foreach ($dantoc as $dt)
                                            <option value="{{ $dt }}" @selected(old('ethnicity', $profile->ethnicity) == $dt)>
                                                {{ $dt }}</option>
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
                                    <input type="text" name="cccd_number" class="form-control" placeholder="Nhập CCCD"
                                        value="{{ old('cccd_number', $profile->cccd_number) }}" required>
                                    <span style="font-size: 12px">Số Căn cước/Căn cước công dân đăng ký tài khoản</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Nơi sinh <span class="text-danger">*</span></label>
                                    <select class="form-control" name="birth_place" id="noisinh-select">
                                        <option>Chọn nơi sinh</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" placeholder="Nhập Email"
                                        value="{{ old('email', $profile->email) }}" required>
                                    <span style="font-size: 12px">Email cá nhân đăng ký tài khoản
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại"
                                        value="{{ old('phone', $profile->phone) }}" required>
                                    <span style="font-size: 12px">Ưu tiên số điện thoại có đăng ký ZALO (Nếu có)</span>
                                </div>
                            </div>

                        </div>
                       

                        @php
    $frontUrl = $profile->cccd_front_path
        ? asset('upload/'.$profile->cccd_front_path)
        : asset('assets/img/mat-truoc-cc.png');

    $backUrl = $profile->cccd_back_path
        ? asset('upload/'.$profile->cccd_back_path)
        : asset('assets/img/mat-sau-cc.png');
@endphp

<div class="row mb-3">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="fw-bold mb-2">Hình ảnh Căn cước/Căn cước công dân<span class="text-danger">*</span></label>
            <div class="text-center border border-dashed border-secondary rounded border-opacity-50 p-2">
                <img id="preview_front" class="w-75"
                     src="{{ $frontUrl }}"
                     alt="CCCD mặt trước"
                     onerror="this.src='{{ asset('assets/img/mat-truoc-cc.png') }}'">
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label class="fw-bold mb-2">&nbsp;</label>
            <div class="text-center border border-dashed border-secondary rounded border-opacity-50 p-2">
                <img id="preview_back" class="w-75"
                     src="{{ $backUrl }}"
                     alt="CCCD mặt sau"
                     onerror="this.src='{{ asset('assets/img/mat-sau-cc.png') }}'">
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group mb-3">
            <label class="fw-bold mb-2 d-block">Mặt trước:</label>
            <input type="file" id="cccd_front" name="cccd_front_path" class="d-none" accept="image/*">
            <label for="cccd_front" class="btn btn-secondary btn-block">CHỌN HÌNH ẢNH CĂN CƯỚC MẶT TRƯỚC</label>
            <small id="cccd_front_name" class="text-muted ms-1">
                @if($profile->cccd_front_path) {{ basename($profile->cccd_front_path) }} @endif
            </small>
        </div>

        <div class="form-group">
            <label class="fw-bold mb-2 d-block">Mặt sau:</label>
            <input type="file" id="cccd_back" name="cccd_back_path" class="d-none" accept="image/*">
            <label for="cccd_back" class="btn btn-secondary btn-block">CHỌN HÌNH ẢNH CĂN CƯỚC MẶT SAU</label>
            <small id="cccd_back_name" class="text-muted ms-1">
                @if($profile->cccd_back_path) {{ basename($profile->cccd_back_path) }} @endif
            </small>
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
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Đối tượng ưu tiên <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="priority_object" required>
                                        <option value="10"
                                            @selected(old('priority_object', $profile->priority_object) == '10')>10 - Không
                                            thuộc diện ưu tiên</option>
                                        <option value="07"
                                            @selected(old('priority_object', $profile->priority_object) == '07')>07</option>
                                        <option value="06"
                                            @selected(old('priority_object', $profile->priority_object) == '06')>06</option>
                                        <option value="05"
                                            @selected(old('priority_object', $profile->priority_object) == '05')>05</option>
                                        <option value="04"
                                            @selected(old('priority_object', $profile->priority_object) == '04')>04</option>
                                        <option value="03"
                                            @selected(old('priority_object', $profile->priority_object) == '03')>03</option>
                                        <option value="02"
                                            @selected(old('priority_object', $profile->priority_object) == '02')>02</option>
                                        <option value="01"
                                            @selected(old('priority_object', $profile->priority_object) == '01')>01</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Khu vực ưu tiên <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="priority_area" required>
                                        <option value="KV3"     @selected(old('priority_area',$profile->priority_area)=='KV3')>Khu vực 3</option>
        <option value="KV2-NT" @selected(old('priority_area',$profile->priority_area)=='KV2-NT')>Khu vực 2 - Nông thôn</option>
        <option value="KV2" @selected(old('priority_area',$profile->priority_area)=='KV2')>Khu vực 2</option>
        <option value="KV1" @selected(old('priority_area',$profile->priority_area)=='KV1')>Khu vực 1</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Năm tốt nghiệp THPT <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="graduation_year" placeholder="Năm tốt nghiệp" class="form-control " value="{{ old('graduation_year',$profile->graduation_year) }}">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">THÔNG TIN NGƯỜI LIÊN HỆ (BỐ/MẸ/NGƯỜI GIÁM HỘ)
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <p>Khi cần liên hệ với ai?</p>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <!-- text input -->

                                <div class="form-group">
                                    <label class="fw-bold mb-2">Họ và tên
                                        <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_name" class="form-control" placeholder="Họ và tên" value="{{ old('contact_name',$profile->contact_name) }}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Quan hệ <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="contact_relation" required>
                                        <option value="Bố" @selected(old('contact_relation',$profile->contact_relation)=='Bố')>Bố</option>
        <option value="Mẹ" @selected(old('contact_relation',$profile->contact_relation)=='Mẹ')>Mẹ</option>
        <option value="Người giám hộ"  @selected(old('contact_relation',$profile->contact_relation)=='Người giám hộ')>Người giám hộ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_phone" class="form-control" placeholder="Số điện thoại" value="{{ old('contact_phone',$profile->contact_phone) }}">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <!-- text input -->
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Email</label>
                                    <input name="contact_email" type="email" class="form-control" placeholder="Email" value="{{ old('contact_email',$profile->contact_email) }}">
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
document.addEventListener('DOMContentLoaded', function () {
    const defaultFront = @json(asset('assets/img/mat-truoc-cc.png'));
    const defaultBack  = @json(asset('assets/img/mat-sau-cc.png'));

    function previewImage(inputEl, imgSelector, nameSelector, fallbackUrl) {
        const img = document.querySelector(imgSelector);
        const nameEl = document.querySelector(nameSelector);

        if (!inputEl.files || !inputEl.files[0]) {
            img.src = fallbackUrl;
            if (nameEl) nameEl.textContent = '';
            return;
        }

        const file = inputEl.files[0];
        if (!file.type.match(/^image\//)) {
            // Không phải ảnh → quay về ảnh mặc định
            img.src = fallbackUrl;
            if (nameEl) nameEl.textContent = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            if (nameEl) nameEl.textContent = file.name;
        };
        reader.readAsDataURL(file);
    }

    const frontInput = document.getElementById('cccd_front');
    const backInput  = document.getElementById('cccd_back');

    if (frontInput) {
        frontInput.addEventListener('change', function () {
            previewImage(frontInput, '#preview_front', '#cccd_front_name', defaultFront);
        });
    }
    if (backInput) {
        backInput.addEventListener('change', function () {
            previewImage(backInput, '#preview_back', '#cccd_back_name', defaultBack);
        });
    }
});
</script>

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
        // Lấy giá trị cũ từ Laravel (old hoặc DB)
        let currentValue = @json(old('birth_place', $profile->birth_place));

        $.getJSON('https://raw.githubusercontent.com/madnh/hanhchinhvn/master/dist/tinh_tp.json', function (data) {
            $.each(data, function (key, value) {
                $('#noisinh-select').append($('<option>', {
                    value: value.name,
                    text: value.name
                }));
            });

            // Set selected khi edit hoặc khi submit lỗi
            if (currentValue) {
                $('#noisinh-select').val(currentValue).trigger('change');
            }
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