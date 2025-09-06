@extends('layout')
@section('title', 'Quy đổi điểm theo độ chênh tổ hợp')

@section('content')
    <div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Quy đổi điểm theo độ chênh tổ hợp (so với D01)</h3>
            </div>

            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Phương thức <span class="text-danger">*</span></label>
                        <select id="method" class="form-control">
                            <option value="">Áp dụng chung</option>
                            @foreach ($methods as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tổ hợp <span class="text-danger">*</span></label>
                        <select id="combo_code" class="form-control">
                            @foreach ($comboLabels as $code => $label)
                                @if ($code !== 'D01')
                                    {{-- thí sinh chọn tổ hợp cần quy đổi; D01 là mốc --}}
                                    <option value="{{ $code }}">{{ $code }} — {{ $label }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Điểm <span class="text-danger">*</span></label>
                        <input id="score" type="number" step="0.01" min="0" max="30"
                            class="form-control" placeholder="0–30" value="26">
                    </div>

                </div>
                <div class="row mt-2">
                    <div class="col-md-2">
                        <button id="btnConvert" class="btn btn-primary w-100">Quy đổi điểm</button>
                    </div>

                </div>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Mốc</th>
                                <th class="text-nowrap">Tổ hợp</th>
                                <th class="text-nowrap">Độ chênh</th>
                                <th class="text-nowrap text-end">Điểm quy đổi</th>
                            </tr>
                        </thead>
                        <tbody id="resultBody">
                            <tr>
                                <td><span class="badge bg-secondary">D01</span></td>
                                <td id="res_combo">—</td>
                                <td id="res_delta">—</td>
                                <td id="res_score" class="text-end fw-bold text-primary">—</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <small class="text-muted">Công thức: Điểm quy đổi = Điểm nhập − Độ chênh (so với D01). Độ chênh âm sẽ làm
                    tăng điểm quy đổi.</small>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data từ server
            const OFFSETS = @json($offsets); // [{combo_code, base_code, method, delta},...]
            const COMBO_LABELS = @json($comboLabels);
            const BASE_CODE = 'D01';

            // Helpers
            const fmtVN = (n) => (isNaN(n) ? '—' : n.toFixed(2).replace('.', ','));

            // Tìm delta: ưu tiên khớp method; nếu không có → rơi về bản chung (method null)
            function findDelta(combo, method) {
                if (combo === BASE_CODE) return 0;

                // exact match (combo, base=D01, method)
                let hit = OFFSETS.find(o =>
                    (o.combo_code || '').toUpperCase() === combo.toUpperCase() &&
                    (o.base_code || '').toUpperCase() === BASE_CODE &&
                    (o.method || '') === (method || null)
                );
                if (hit) return parseFloat(hit.delta);

                // fallback: method null/chung
                hit = OFFSETS.find(o =>
                    (o.combo_code || '').toUpperCase() === combo.toUpperCase() &&
                    (o.base_code || '').toUpperCase() === BASE_CODE &&
                    (o.method === null || o.method === '')
                );
                return hit ? parseFloat(hit.delta) : 0;
            }

            function doConvert() {
                const method = document.getElementById('method').value || null;
                const combo = document.getElementById('combo_code').value;
                const raw = parseFloat(document.getElementById('score').value);

                if (isNaN(raw)) {
                    alert('Vui lòng nhập điểm hợp lệ.');
                    return;
                }

                const delta = findDelta(combo, method);
                const converted = raw - delta;

                // Render
                document.getElementById('res_combo').textContent =
                    `${combo} — ${COMBO_LABELS[combo] ?? ''}`;
                document.getElementById('res_delta').textContent = fmtVN(delta);
                document.getElementById('res_score').textContent = fmtVN(converted);
            }

            document.getElementById('btnConvert').addEventListener('click', doConvert);
            document.getElementById('score').addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    doConvert();
                }
            });

            // chạy lần đầu để có kết quả mẫu
            doConvert();
        });
    </script>
@endsection
