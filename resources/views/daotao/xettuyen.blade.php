@extends('layout')
@section('title', 'VIMARU - Tuyển sinh')


@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Trang chủ</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Trang chủ
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
            <!--begin::Row-->
            <div class="row">
                <h2 class="mb-4">Danh sách thí sinh</h2>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Điểm</th>
                            <th>Nguyện vọng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($thiSinhs as $index => $ts)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ts['ten'] }}</td>
                                <td>{{ $ts['diem'] }}</td>
                                <td>{{ implode(' → ', $ts['nguyen_vongs']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Nút Xét tuyển --}}
                <form id="xetTuyenForm" method="POST" action="{{ route('xettuyen.chay') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Chỉ tiêu ngành CNTT:</label>
                            <input type="number" name="quota[CNTT]" class="form-control" value="2" min="0">
                        </div>
                        <div class="col-md-4">
                            <label>Chỉ tiêu ngành TĐH:</label>
                            <input type="number" name="quota[TDH]" class="form-control" value="2" min="0">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100"> Xét tuyển</button>
                        </div>
                    </div>
                </form>
                <br>

                {{-- Hiển thị kết quả nếu đã xét tuyển --}}
                @if (isset($daXetTuyen) && $daXetTuyen)
                    <hr>
                    <h3>Kết quả trúng tuyển</h3>
                    <table class="table table-bordered table-success">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ tên</th>
                                <th>Điểm</th>
                                <th>Kết quả</th>
                                <th>Nguyện vọng trúng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($thiSinhs as $index => $ts)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ts['ten'] }}</td>
                                    <td>{{ $ts['diem'] }}</td>
                                    <td>
                                        @if ($ts['trang_thai'] === 'trung_tuyen')
                                            <span class="badge bg-success">Trúng tuyển</span>
                                        @elseif ($ts['trang_thai'] === 'rot')
                                            <span class="badge bg-danger">Rớt</span>
                                        @else
                                            {{ $ts['trang_thai'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ts['trang_thai'] === 'trung_tuyen')
                                            {{ $ts['nguyen_vongs'][$ts['index_nv']] }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <!--end::Row-->

        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->

@endsection
