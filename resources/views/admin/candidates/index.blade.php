@extends('layout')
@section('title', 'Quản lý hồ sơ thí sinh')

@section('content')
    <div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Danh sách thí sinh</h3>
            </div>

            {{-- TOP pagination --}}
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                <small class="text-muted mb-0">
                    @if($users->total() > 0)
                        Hiển thị {{ $users->firstItem() }}–{{ $users->lastItem() }} / {{ $users->total() }}
                    @else
                        Không có dữ liệu
                    @endif
                </small>
                {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:60px" class="text-center">#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>CCCD</th>
                            <th class="text-center" style="width:120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $u)
                            @php $p = $u->profile; @endphp
                            <tr>
                                <td class="text-center">{{ $users->firstItem() + $i }}</td>
                                <td>{{ $u->hoten }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->cccd }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-view-profile"
                                        data-user='{{ json_encode($u->only(["id", "hoten", "email", "cccd"])) }}'
                                        data-profile='{{ json_encode($u->profile) }}' data-bs-toggle="modal"
                                        data-bs-target="#profileModal">
                                        Xem
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có thí sinh.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- BOTTOM pagination --}}
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted mb-0">
                    @if($users->total() > 0)
                        Hiển thị {{ $users->firstItem() }}–{{ $users->lastItem() }} / {{ $users->total() }}
                    @else
                        Không có dữ liệu
                    @endif
                </small>
                {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Modal xem profile --}}
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Hồ sơ thí sinh <span id="m_hoten" class="text-primary"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><b>Họ tên:</b> <span id="m_full_name"></span></li>
                                <li><b>Ngày sinh:</b> <span id="m_dob"></span></li>
                                <li><b>Giới tính:</b> <span id="m_gender"></span></li>
                                <li><b>Dân tộc:</b> <span id="m_ethnicity"></span></li>
                                <li><b>CCCD:</b> <span id="m_cccd_number"></span></li>
                                <li><b>Nơi sinh:</b> <span id="m_birth_place"></span></li>
                                <li><b>Điện thoại:</b> <span id="m_phone"></span></li>
                                <li><b>Email:</b> <span id="m_email"></span></li>
                                <li><b>Địa chỉ:</b> <span id="m_address"></span></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><b>Đối tượng ưu tiên:</b> <span id="m_priority_object"></span></li>
                                <li><b>Khu vực ưu tiên:</b> <span id="m_priority_area"></span></li>
                                <li><b>Năm tốt nghiệp:</b> <span id="m_graduation_year"></span></li>
                                <li><b>Người liên hệ:</b> <span id="m_contact_name"></span></li>
                                <li><b>Quan hệ:</b> <span id="m_contact_relation"></span></li>
                                <li><b>SĐT liên hệ:</b> <span id="m_contact_phone"></span></li>
                                <li><b>Email liên hệ:</b> <span id="m_contact_email"></span></li>
                                <li><b>Ghi chú:</b> <span id="m_note"></span></li>
                            </ul>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="border rounded p-2">
                                <img id="m_front" class="img-fluid" src="{{ asset('assets/img/mat-truoc-cc.png') }}"
                                    alt="CCCD Mặt trước" onerror="this.src='{{ asset('assets/img/mat-truoc-cc.png') }}'">
                                <div class="small text-muted mt-1">Mặt trước</div>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="border rounded p-2">
                                <img id="m_back" class="img-fluid" src="{{ asset('assets/img/mat-sau-cc.png') }}"
                                    alt="CCCD Mặt sau" onerror="this.src='{{ asset('assets/img/mat-sau-cc.png') }}'">
                                <div class="small text-muted mt-1">Mặt sau</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Nếu bạn lưu ảnh ở public/upload: set baseUpload; nếu ở storage: baseStorage
            const baseUpload = @json(asset('upload'));   // ví dụ: http://app.local/upload
            const baseStorage = @json(asset('storage'));  // ví dụ: http://app.local/storage

            function buildImageUrl(path) {
                if (!path) return null;
                // Ưu tiên public/upload (nếu bạn đang dùng giải pháp upload vào public/upload)
                const u = baseUpload + '/' + path;
                return { primary: u, fallback: baseStorage + '/' + path };
            }

            function text(el, v) { el.textContent = (v ?? '').toString(); }

            $('.btn-view-profile').on('click', function () {
                const user = $(this).data('user') || {};
                const profile = $(this).data('profile') || {};

                // Header
                text(document.getElementById('m_hoten'), user.hoten || profile.full_name || '');

                // Trái
                text(document.getElementById('m_full_name'), profile.full_name || user.hoten || '');
                text(document.getElementById('m_dob'), profile.dob || '');
                const gmap = { male: 'Nam', female: 'Nữ' };
                text(document.getElementById('m_gender'), gmap[profile.gender] || '');
                text(document.getElementById('m_ethnicity'), profile.ethnicity || '');
                text(document.getElementById('m_cccd_number'), profile.cccd_number || user.cccd || '');
                text(document.getElementById('m_birth_place'), profile.birth_place || '');
                text(document.getElementById('m_phone'), profile.phone || '');
                text(document.getElementById('m_email'), profile.profile_email || user.email || '');
                text(document.getElementById('m_address'), profile.address || '');

                // Phải
                text(document.getElementById('m_priority_object'), profile.priority_object || '');
                text(document.getElementById('m_priority_area'), profile.priority_area || '');
                text(document.getElementById('m_graduation_year'), profile.graduation_year || '');
                text(document.getElementById('m_contact_name'), profile.contact_name || '');
                text(document.getElementById('m_contact_relation'), profile.contact_relation || '');
                text(document.getElementById('m_contact_phone'), profile.contact_phone || '');
                text(document.getElementById('m_contact_email'), profile.contact_email || '');
                text(document.getElementById('m_note'), profile.note || '');

                // Ảnh
                const front = buildImageUrl(profile.cccd_front_path);
                const back = buildImageUrl(profile.cccd_back_path);

                const imgFront = document.getElementById('m_front');
                const imgBack = document.getElementById('m_back');

                if (front) {
                    imgFront.src = front.primary;
                    imgFront.onerror = function () { this.onerror = null; this.src = front.fallback; };
                } else {
                    imgFront.src = @json(asset('assets/img/mat-truoc-cc.png'));
                }
                if (back) {
                    imgBack.src = back.primary;
                    imgBack.onerror = function () { this.onerror = null; this.src = back.fallback; };
                } else {
                    imgBack.src = @json(asset('assets/img/mat-sau-cc.png'));
                }
            });
        });
    </script> --}}
@endsection