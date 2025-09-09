@extends('layout')
@section('title', 'Quản lý nguyện vọng')

@section('content')
    <div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Danh sách nguyện vọng</h3>

                <div class="card-tools d-flex align-items-center flex-wrap gap-2">
                    {{-- Nhóm nút chế độ xét tuyển --}}
                    <div class="btn-group me-2" role="group" aria-label="Xét tuyển">
                        {{-- <a href="" class="btn btn-sm btn-warning mx-3">
                            <i class="fa-solid fa-chart-line me-1"></i> Xét theo điểm
                        </a> --}}
                        <form action="{{ route('wishes.runQuota') }}" method="POST"
                            onsubmit="return confirm('Chạy xét tuyển (cho vượt nếu đồng điểm ở biên)?');">
                            @csrf
                            <input type="hidden" name="tie" value="overflow">
                            <button class="btn btn-sm btn-outline-warning">
                                <i class="fa-solid fa-person-arrow-up-from-line me-1"></i> Xét theo chỉ tiêu
                            </button>
                        </form>
                    </div>

                    {{-- Ô tìm kiếm --}}
                    <form method="GET" class="input-group input-group-sm" style="width: 460px;"> <input type="text"
                            name="q" class="form-control float-right" placeholder="Tìm tên/email/CCCD"
                            value="{{ $q }}">
                        <div class="input-group-append"> <button type="submit" class="btn btn-primary"><i
                                    class="fas fa-search"></i></button> </div>
                    </form>
                </div>
            </div>


            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:70px">#</th>
                            <th>Thí sinh</th>
                            <th>Email</th>
                            <th>CCCD</th>
                            <th class="text-center" style="width:80px">NV</th>
                            <th style="width:140px">Mã ngành</th>
                            <th>Chuyên ngành</th>
                            <th style="width:140px">SBD</th>
                            <th class="text-end" style="width:140px">Điểm quy đổi</th>
                            <th class="text-center" style="width:120px">Trạng thái</th>
                            <th class="text-nowrap" style="width:160px">Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wishes as $i => $w)
                            @php
                                $u = $w->user; // hoten, email, cccd
                                $m = $w->major; // code, name
                            @endphp
                            <tr>
                                <td class="text-center">{{ $wishes->firstItem() + $i }}</td>
                                <td>{{ $u->hoten ?? '—' }}</td>
                                <td>{{ $u->email ?? '—' }}</td>
                                <td>{{ $u->cccd ?? '—' }}</td>
                                <td class="text-center">{{ $w->order_no }}</td>
                                <td>
                                    <span class="badge bg-dark">{{ $m->code ?? $w->major_code }}</span>
                                </td>
                                <td>{{ $m->name ?? '—' }}</td>
                                <td>{{ $w->exam_id ?? '—' }}</td>
                                <td class="text-end">
                                    {{ is_null($w->converted_score) ? '—' : number_format($w->converted_score, 2) }}</td>
                                <td class="text-center">
                                    <span
                                        class="badge {{ $w->status === 'accepted' ? 'bg-success' : ($w->status === 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $w->status }}
                                    </span>
                                </td>
                                <td class="text-nowrap">{{ $w->created_at?->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">Chưa có nguyện vọng.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- BOTTOM pagination --}}
            <div class="card-footer d-flex justify-content-end align-items-center">
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="mx-3 mb-2">Tổng {{ $wishes->total() }} bản ghi </small>
                    <div class="align-items-center">
                        {{ $wishes->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
