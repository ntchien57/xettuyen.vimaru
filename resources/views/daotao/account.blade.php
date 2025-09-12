@extends('layout')
@section('title', 'Quản lý tài khoản')

@section('content')
    <div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title mb-0">Quản lý tài khoản</h3>

                <div class="d-flex align-items-center gap-2">

                    {{-- Form tìm kiếm --}}
                    <form method="GET" class="d-flex align-items-center gap-2">
                        <select name="role" class="form-control form-select" style="width: 200px;">
                            <option value="">— Tất cả vai trò —</option>
                            <option value="0" @selected($role === '0')>Thí sinh</option>
                            <option value="1" @selected($role === '1')>Phòng đào tạo</option>
                        </select>

                        <div class="input-group input-group-sm" style="width: 320px;">
                            <input type="text" name="q" class="form-control" placeholder="Tìm họ tên/email/CCCD"
                                value="{{ $q }}">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    {{-- Nút thêm --}}
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="fa fa-user-plus me-1"></i> Thêm tài khoản
                    </button>

                </div>
            </div>
            {{-- Bảng --}}
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:60px;" class="text-center">#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>CCCD</th>
                            <th style="width:120px;">Vai trò</th>
                            <th style="width:100px;">Trạng thái</th>
                            <th style="width:160px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $u)
                            <tr>
                                <td class="text-center">{{ $users->firstItem() + $i }}</td>
                                <td>{{ $u->hoten }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->cccd ?? '—' }}</td>
                                <td>
                                    @if ((int) $u->role === 1)
                                        <span class="badge bg-primary">Quản trị</span>
                                    @else
                                        <span class="badge bg-secondary">Thí sinh</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($u->active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-danger">Khoá</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editUserModal" data-user='@json($u)'>
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <form method="POST" action="{{ route('daotao.account.destroy', $u->id) }}"
                                        class="d-inline" onsubmit="return confirm('Xoá tài khoản này?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Không có dữ liệu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer paginate --}}
            <div class="card-footer d-flex justify-content-end align-items-center">
                        
                {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Modal: Tạo --}}
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('daotao.account.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="fw-bold">Họ tên</label>
                        <input type="text" name="hoten" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">CCCD</label>
                        <input type="text" name="cccd" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">Mật khẩu</label>
                        <input type="password" name="matkhau" class="form-control" minlength="6" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="fw-bold">Vai trò</label>
                            <select name="role" class="form-control form-select">
                                <option value="0">Thí sinh</option>
                                <option value="1">Phòng đào tạo</option>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="fw-bold d-block">Trạng thái</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="active" value="1" checked>
                                <label class="form-check-label">Hoạt động</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Lưu</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Sửa --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editUserForm" class="modal-content" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Sửa tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="fw-bold">Họ tên</label>
                        <input type="text" name="hoten" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">CCCD</label>
                        <input type="text" name="cccd" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="fw-bold">Mật khẩu (để trống nếu không đổi)</label>
                        <input type="password" name="matkhau" class="form-control" minlength="6">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <label class="fw-bold">Vai trò</label>
                            <select name="role" class="form-control form-select">
                                <option value="0">Thí sinh</option>
                                <option value="1">Phòng đào tạo</option>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="fw-bold d-block">Trạng thái</label>
                            <div class="form-check form-switch mt-2">
                                <input type="hidden" name="active" value="0">
                                <input class="form-check-input" type="checkbox" name="active" value="1"
                                    id="edit_active">
                                <label class="form-check-label" for="edit_active">Hoạt động</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Lưu</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editUserModal');
            modal.addEventListener('show.bs.modal', function(ev) {
                const btn = ev.relatedTarget;
                const u = JSON.parse(btn.getAttribute('data-user') || '{}');
                const form = document.getElementById('editUserForm');
                form.action = "{{ route('daotao.account.update', '__ID__') }}".replace('__ID__', u.id);

                form.querySelector('[name="hoten"]').value = u.hoten ?? '';
                form.querySelector('[name="email"]').value = u.email ?? '';
                form.querySelector('[name="cccd"]').value = u.cccd ?? '';
                form.querySelector('[name="matkhau"]').value = '';
                form.querySelector('[name="role"]').value = (u.role ?? 0);
                form.querySelector('[name="active"]').checked = !!u.active;
            });
        });
    </script>
@endsection
