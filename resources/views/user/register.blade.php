@extends('layout')
@section('title', 'VIMARU - Đăng ký xét tuyển')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Đăng ký xét tuyển</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Đăng ký xét tuyển</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            {{-- Thông báo --}}
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

            <form action="{{ route('wishesStore') }}" method="POST">
                @csrf
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">ĐĂNG KÝ NGUYỆN VỌNG</h3>
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Số báo danh THPT <span class="text-danger">*</span></label>
                                    <input type="text" name="exam_id" class="form-control"
                                        value="{{ old('exam_id',  $wishes1?->exam_id) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Điểm quy đổi (tính điểm quy đổi tổ hợp xét tuyển ở phần công cụ quy đổi điểm) <span class="text-danger">*</span></label>
                                    <input type="text" name="converted_score" class="form-control"
                                        value="{{ old('converted_score',   $wishes1?->converted_score) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="d-flex border-bottom pb-2 mb-2 text-muted small">
                                <div style="width:60px;">NV</div>
                                <div class="flex-grow-1">Chuyên ngành xét tuyển</div>
                                <div style="width:48px;"></div>
                            </div>

                            <div id="nv-list"></div>

                            <div class="col-sm-2">
                                <button type="button" id="btn-add" class="btn btn-outline-primary btn-sm mt-3">
                                    + Thêm nguyện vọng
                                </button>
                            </div>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary" type="submit">Nộp nguyện vọng</button>
                        </div>
                    </div>
                </div>

                {{-- Template 1 dòng NV --}}
                <template id="nv-row-tpl">
                    <div class="d-flex align-items-center py-2 border-bottom nv-row">
                        <div class="text-muted" style="width:60px;">
                            <span class="nv-index">1</span>
                        </div>
                        <div class="flex-grow-1 pe-2">
                            <select class="form-control form-select major-select" name="" required>
                                <option value="" disabled selected>— Chọn chuyên ngành —</option>
                                @foreach ($majors as $m)
                                    <option value="{{ $m->code }}">{{ $m->code }} - {{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-end" style="width:48px;">
                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove" title="Xóa">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </template>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function() {
            const list = document.getElementById('nv-list');
            const tpl = document.getElementById('nv-row-tpl');
            const btnAdd = document.getElementById('btn-add');

            // data khởi tạo: ưu tiên old(), sau đó tới wishes đã lưu
            const initial = @json(old('nguyenvong') ? collect(old('nguyenvong'))->pluck('major_code')->filter()->values() : $wishes ?? collect());

            function addRow(prefillCode = '') {
                const frag = tpl.content.cloneNode(true);
                const row = frag.querySelector('.nv-row');
                const select = row.querySelector('.major-select');

                if (prefillCode) select.value = prefillCode;

                row.querySelector('.btn-remove').addEventListener('click', function() {
                    row.remove();
                    refreshIndexes();
                });

                list.appendChild(frag);
                refreshIndexes();
            }

            function refreshIndexes() {
                const rows = list.querySelectorAll('.nv-row');
                rows.forEach((r, idx) => {
                    r.querySelector('.nv-index').textContent = (idx + 1).toString();
                    const select = r.querySelector('.major-select');
                    select.name = `nguyenvong[${idx}][major_code]`;
                });
            }

            btnAdd.addEventListener('click', () => addRow());

            // Khởi tạo: nếu có dữ liệu → load; nếu không → 1 dòng trống
            if (Array.isArray(initial) && initial.length) {
                initial.forEach(code => addRow(code));
            } else {
                addRow();
            }
        })();
    </script>
@endsection
