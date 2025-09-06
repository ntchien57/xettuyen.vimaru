@extends('layout')
@section('title', 'Độ chênh tổ hợp')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            {{-- Form thêm mới --}}
            <div class="col-lg-4">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Thêm độ chênh tổ hợp</h3>
                    </div>
                    <form action="{{ route('combo-offsets.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="fw-bold">Tổ hợp</label>
                                <select name="combo_code" class="form-control" required>
                                    @foreach ($comboOptions as $c)
                                        <option value="{{ $c }}" @selected(old('combo_code') === $c)>{{ $c }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @php $baseDefault = 'D01'; @endphp
                            <div class="mb-2">
                                <label class="fw-bold">Tổ hợp gốc</label>
                                <input type="text" class="form-control"
                                    value="D01{{ isset($comboOptions['D01']) ? ' — ' . $comboOptions['D01'] : '' }}"
                                    readonly>
                                <input type="hidden" name="base_code" value="{{ $baseDefault }}">
                                <small class="text-muted">Theo bảng gốc thường dùng D01 làm mốc.</small>
                            </div>

                            <div class="mb-2">
                                <label class="fw-bold">Phương thức</label>
                                <select name="method" class="form-control">
                                    <option value="">Áp dụng chung</option>
                                    @foreach ($methodOptions as $m)
                                        <option value="{{ $m }}" @selected(old('method') === $m)>{{ $m }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="fw-bold">Độ chênh tổ hợp</label>
                                    <input type="number" step="0.01" name="delta" value="{{ old('delta', 0) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="fw-bold">Thứ tự</label>
                                    <input type="number" name="order_no" value="{{ old('order_no', 0) }}" min="0"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="active" value="1" id="active"
                                    checked>
                                <label class="form-check-label" for="active">Kích hoạt</label>
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
                        <h3 class="card-title">Danh sách độ chênh tổ hợp</h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width:60px" class="text-center">#</th>
                                    <th>Tổ hợp</th>
                                    <th>Tổ hợp gốc</th>
                                    <th>Phương thức</th>
                                    <th class="text-end">Độ chênh</th>
                                    <th class="text-center" style="width:90px">TT</th>
                                    <th class="text-center" style="width:160px">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($offsets as $i => $o)
                                    <tr>
                                        <td class="text-center">{{ $offsets->firstItem() + $i }}</td>
                                        <td><span class="badge bg-dark">{{ $o->combo_code }}</span></td>
                                        <td><span class="badge bg-secondary">{{ $o->base_code }}</span></td>
                                        <td>{{ $o->method ?? 'Chung' }}</td>
                                        <td class="text-end">{{ number_format($o->delta, 2) }}</td>
                                        <td class="text-center">{{ $o->order_no }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editOffsetModal"
                                                data-offset='@json($o)'>
                                                <i class="fas fa-pencil"></i>
                                            </button>
                                            <form action="{{ route('combo-offsets.destroy', $o) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Xoá bản ghi {{ $o->combo_code }}?');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i
                                                        class="fas fa-trash"></i></button>
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
                    </div>

                    {{-- BOTTOM pagination --}}
                    <div class="card-footer d-flex justify-content-end align-items-center">
                        <div class="mt-2">

                            {{ $offsets->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal sửa --}}
    <div class="modal fade" id="editOffsetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editOffsetForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Sửa độ chênh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="fw-bold">Tổ hợp</label>
                            <select name="combo_code" id="edit_combo_code" class="form-control" required>
                                @foreach ($comboOptions as $key => $val)
                                    @php
                                        // Hỗ trợ cả 2 dạng: ['A00'=>'Toán, Lý, Hóa'] hoặc ['A00','A01',...]
                                        $code = is_string($key) ? $key : $val;
                                        $label = is_string($key) ? $key . ' — ' . $val : $val;
                                    @endphp
                                    <option value="{{ $code }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="fw-bold">Mốc (base)</label>
                            <select name="base_code" id="edit_base_code" class="form-control" required>
                                @foreach ($comboOptions as $key => $val)
                                    @php
                                        $code = is_string($key) ? $key : $val;
                                        $label = is_string($key) ? $key . ' — ' . $val : $val;
                                    @endphp
                                    <option value="{{ $code }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="fw-bold">Phương thức</label>
                            <select name="method" class="form-control">
                                <option value="">Áp dụng chung</option>
                                @foreach ($methodOptions as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="fw-bold">Độ chênh</label>
                                <input type="number" step="0.01" name="delta" class="form-control" required>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="fw-bold">Thứ tự</label>
                                <input type="number" name="order_no" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="active" id="edit_active"
                                value="1">
                            <label class="form-check-label" for="edit_active">Kích hoạt</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Lưu</button>
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editOffsetModal');
            modal.addEventListener('show.bs.modal', function(ev) {
                const m = JSON.parse(ev.relatedTarget.getAttribute('data-offset') || '{}');
                const form = document.getElementById('editOffsetForm');
                form.action = "{{ url('dao-tao/combo-offsets') }}/" + m.id;

                form.querySelector('[name="combo_code"]').value = m.combo_code || '';
                form.querySelector('[name="base_code"]').value = m.base_code || 'D01';
                form.querySelector('[name="method"]').value = m.method || '';
                form.querySelector('[name="delta"]').value = m.delta ?? 0;
                form.querySelector('[name="order_no"]').value = m.order_no ?? 0;
                form.querySelector('[name="active"]').checked = !!m.active;
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editOffsetModal');

            modal.addEventListener('show.bs.modal', function(ev) {
                const data = ev.relatedTarget.getAttribute('data-offset') || '{}';
                const m = JSON.parse(data);
                const form = document.getElementById('editOffsetForm');

                // action update
                form.action = "{{ url('dao-tao/combo-offsets') }}/" + m.id;

                // set select values
                setSelect(form, 'combo_code', m.combo_code);
                setSelect(form, 'base_code', m.base_code || 'D01');
                setSelect(form, 'method', m.method || '');

                // numbers & checkbox
                form.querySelector('[name="delta"]').value = (m.delta ?? 0);
                form.querySelector('[name="order_no"]').value = (m.order_no ?? 0);
                form.querySelector('#edit_active').checked = !!m.active;
            });

            // Chọn option theo value; nếu option chưa có thì tự thêm rồi chọn
            function setSelect(form, name, value) {
                const el = form.querySelector(`[name="${name}"]`);
                if (!el) return;
                let matched = false;
                [...el.options].forEach(opt => {
                    if (opt.value == (value ?? '')) {
                        opt.selected = true;
                        matched = true;
                    } else {
                        opt.selected = false;
                    }
                });
                if (!matched && value) {
                    const opt = new Option(value, value, true, true);
                    el.add(opt);
                }
                // Nếu bạn dùng select2, bật dòng dưới:
                // if ($(el).hasClass('select2')) $(el).val(value).trigger('change');
            }
        });
    </script>

@endsection
