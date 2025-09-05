@extends('layout')
@section('title', 'Quản lý Chuyên ngành')

@section('content')
    <div class="container-fluid">

        <div class="row">
            {{-- Form thêm mới --}}
            <div class="col-lg-4">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Thêm chuyên ngành</h3>
                    </div>
                    <form action="{{ route('majors.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="fw-bold">Mã CN</label>
                                <input type="text" name="code" class="form-control" placeholder="D101" required>
                            </div>
                            <div class="mb-2">
                                <label class="fw-bold">Tên chuyên ngành</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="fw-bold">Nhóm</label>
                                <input type="text" name="group_name" class="form-control"
                                    placeholder="Kỹ thuật & Công nghệ">
                            </div>
                            <div class="mb-2">
                                <label class="fw-bold d-block">Tổ hợp xét tuyển</label>
                                <select name="exam_combos[]" class="form-control select2" multiple>
                                    @foreach ($comboOptions as $c)
                                        <option value="{{ $c }}">{{ $c }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Giữ Ctrl/Cmd để chọn nhiều.</small>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="fw-bold">Thứ tự</label>
                                    <input type="number" name="order_no" class="form-control" value="0" min="0">
                                </div>
                                <div class="col-6 mb-2 d-flex align-items-end gap-2 d-none">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" checked>
                                        <label class="form-check-label">Kích hoạt</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 mb-2">
                                <div class="form-check me-3 d-none">
                                    <input class="form-check-input" type="checkbox" name="is_advanced" value="1"
                                        id="is_advanced">
                                    <label class="form-check-label" for="is_advanced">(nâng cao)</label>
                                </div>
                                <div class="form-check me-3 d-none">
                                    <input class="form-check-input" type="checkbox" name="is_optional" value="1"
                                        id="is_optional">
                                    <label class="form-check-label" for="is_optional">(chọn)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="taught_in_english" value="1"
                                        id="taught_in_english">
                                    <label class="form-check-label" for="taught_in_english">Giảng dạy bằng tiếng Anh</label>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="fw-bold">Ghi chú</label>
                                <input type="text" name="note" class="form-control" placeholder="Ghi chú thêm (tuỳ chọn)">
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Danh sách --}}
            <div class="col-lg-8">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách chuyên ngành</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 90px">Mã</th>
                                    <th>Tên chuyên ngành</th>
                                    <th>Nhóm</th>
                                    <th>Tổ hợp</th>
                                    <th class="text-center" style="width: 120px">Giảng dạy</th>
                                    <th class="text-center" style="width: 110px">Thứ tự</th>
                                    <th class="text-center" style="width: 140px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($majors as $m)
                                    <tr>
                                        <td><span class="badge bg-dark">{{ $m->code }}</span></td>
                                        <td>
                                            <div class="fw-semibold">{{ $m->name }}</div>
                                            @if($m->note)<small class="text-muted">{{ $m->note }}</small>@endif
                                        </td>
                                        <td>{{ $m->group_name }}</td>
                                        <td>
                                            @if($m->exam_combos)
                                                @foreach ($m->exam_combos as $c)
                                                    <span class="badge bg-secondary">{{ $c }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($m->is_advanced) <span class="badge bg-info">NC</span> @endif
                                            @if($m->is_optional) <span class="badge bg-warning text-dark">Chọn</span> @endif
                                            @if($m->taught_in_english) <span class="badge bg-success">EN</span> @endif
                                            @if(!$m->active) <span class="badge bg-danger">Off</span> @endif
                                        </td>
                                        <td class="text-center">{{ $m->order_no }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editMajorModal" data-major='@json($m)'>
                                                <i class="fas fa-pencil"></i>
                                            </button>

                                            <form action="{{ route('majors.destroy', $m) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Xoá chuyên ngành {{ $m->name }}?');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Chưa có dữ liệu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="card-footer d-flex flex-wrap align-items-center" style="justify-content: flex-end">
                            <div class="mb-0 mt-2">
                                {{ $majors->onEachSide(1)->links('pagination::bootstrap-4') }}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal sửa --}}
    <div class="modal fade" id="editMajorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form id="editMajorForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa chuyên ngành</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label class="fw-bold">Mã CN</label>
                                <input type="text" name="code" class="form-control" required>
                            </div>
                            <div class="col-md-9">
                                <label class="fw-bold">Tên chuyên ngành</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">Nhóm</label>
                                <input type="text" name="group_name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold">Tổ hợp</label>
                                <select name="exam_combos[]" class="form-control select2-edit" multiple>
                                    @foreach ($comboOptions as $c)
                                        <option value="{{ $c }}">{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 d-flex gap-3 my-2">
                                <div class="form-check d-none">
                                    <input class="form-check-input" type="checkbox" name="is_advanced" id="edit_is_advanced"
                                        value="1">
                                    <label class="form-check-label" for="edit_is_advanced">(nâng cao)</label>
                                </div>
                                <div class="form-check d-none">
                                    <input class="form-check-input" type="checkbox" name="is_optional" id="edit_is_optional"
                                        value="1">
                                    <label class="form-check-label" for="edit_is_optional">(chọn)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="taught_in_english"
                                        id="edit_taught_in_english" value="1">
                                    <label class="form-check-label" for="edit_taught_in_english">Giảng dạy bằng tiếng
                                        Anh</label>
                                </div>
                                <div class="form-check d-none">
                                    <input class="form-check-input" type="checkbox" name="active" id="edit_active"
                                        value="1">
                                    <label class="form-check-label" for="edit_active">Kích hoạt</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="fw-bold">Thứ tự</label>
                                <input type="number" name="order_no" class="form-control" min="0">
                            </div>
                            <div class="col-md-9">
                                <label class="fw-bold">Ghi chú</label>
                                <input type="text" name="note" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Nếu dùng select2
            $('.select2, .select2-edit').select2({ width: '100%' });

            const modal = document.getElementById('editMajorModal');
            modal.addEventListener('show.bs.modal', function (ev) {
                const btn = ev.relatedTarget;
                const m = JSON.parse(btn.getAttribute('data-major'));

                const form = document.getElementById('editMajorForm');
                form.action = "{{ url('dao-tao/majors') }}/" + m.id;

                form.querySelector('[name="code"]').value = m.code ?? '';
                form.querySelector('[name="name"]').value = m.name ?? '';
                form.querySelector('[name="group_name"]').value = m.group_name ?? '';
                form.querySelector('[name="order_no"]').value = m.order_no ?? 0;
                form.querySelector('[name="note"]').value = m.note ?? '';

                // checkboxes
                form.querySelector('[name="is_advanced"]').checked = !!m.is_advanced;
                form.querySelector('[name="is_optional"]').checked = !!m.is_optional;
                form.querySelector('[name="taught_in_english"]').checked = !!m.taught_in_english;
                form.querySelector('[name="active"]').checked = !!m.active;

                // exam_combos
                const sel = $(form).find('.select2-edit');
                sel.val([]).trigger('change');
                if (Array.isArray(m.exam_combos)) {
                    sel.val(m.exam_combos).trigger('change');
                }
            });
        });
    </script>
@endsection