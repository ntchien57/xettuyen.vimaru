@extends('layout')
@section('title', 'VIMARU - Đăng ký xét tuyển')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Kết quả xét tuyển</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kết quả xét tuyển</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Thông tin trúng tuyển</h3>
                </div>

                <div class="card-body">
                    @if ($wishes->isEmpty())
                        <div class="alert alert-info mb-3">
                            Bạn chưa đăng ký nguyện vọng nào. Vui lòng <a href="{{ route('user.registerWishes') }}">đăng ký
                                tại đây</a>.
                        </div>
                    @elseif($accepted)
                        <div class="alert alert-success mb-3">
                            <strong>Chúc mừng!</strong> Bạn đã <u>trúng tuyển</u> ở
                            <strong>NV{{ $accepted->order_no }}</strong>:
                            <span class="badge bg-dark">{{ $accepted->major_code }}</span>
                            <strong>{{ $accepted->major_name ?? '—' }}</strong>.
                            @if (!is_null($accepted->score_d01))
                                Điểm quy đổi D01: <strong>{{ number_format($accepted->score_d01, 2) }}</strong>.
                            @endif
                        </div>
                    @elseif($stats['pending'] > 0)
                        <div class="alert alert-warning mb-3">
                            Các nguyện vọng của bạn đang trong quá trình xét tuyển. Vui lòng theo dõi kết quả sớm nhất.
                        </div>
                    @else
                        <div class="alert alert-danger mb-3">
                            Rất tiếc, bạn chưa trúng tuyển ở bất kỳ nguyện vọng nào.
                        </div>
                    @endif

                    {{-- Bảng chi tiết các nguyện vọng --}}
                    @if (!$wishes->isEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:70px;">NV</th>
                                        <th style="width:120px;">Mã ngành</th>
                                        <th>Chuyên ngành</th>
                                        <th style="width:120px;">SBD</th>
                                        <th class="text-end" style="width:130px;">Điểm D01</th>
                                        <th style="width:140px;">Trạng thái</th>
                                        <th style="width:160px;">Cập nhật</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishes as $w)
                                        @php
                                            $badge = 'secondary';
                                            $label = 'Đang xét';
                                            if ($w->status === 'accepted') {
                                                $badge = 'success';
                                                $label = 'Đã trúng tuyển';
                                            } elseif ($w->status === 'rejected') {
                                                $badge = 'danger';
                                                $label = 'Bị loại';
                                            }
                                        @endphp
                                        <tr>
                                            <td><strong>NV{{ $w->order_no }}</strong></td>
                                            <td><span class="badge bg-dark">{{ $w->major_code }}</span></td>
                                            <td>{{ $w->major_name ?? '—' }}</td>
                                            <td>{{ $w->exam_id ?? '—' }}</td>
                                            <td class="text-end">
                                                {{ is_null($w->score_d01) ? '—' : number_format($w->score_d01, 2) }}</td>
                                            <td><span class="badge bg-{{ $badge }}">{{ $label }}</span></td>
                                            <td class="text-nowrap">
                                                {{ \Carbon\Carbon::parse($w->updated_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection
