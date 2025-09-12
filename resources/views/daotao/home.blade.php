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
    <div class="app-content"
        style="background: url('{{ asset('assets/img/bg-login.png') }}') no-repeat center center; background-size: cover; height:100%">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($totalProfiles) }}</h3>
                            <p>Tổng số hồ sơ thí sinh</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('candidates.index')}}" class="small-box-footer">
                            Xem thêm <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ number_format($totalWishes) }}</h3> {{-- bỏ % nếu là số lượng --}}
                            <p>Tổng số nguyện vọng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('wishes.index')}}" class="small-box-footer">
                            Xem thêm <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ number_format($acceptedStudents) }}</h3>
                            <p>Tổng số thí sinh đỗ</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('ketquaxettuyen')}}" class="small-box-footer">
                            Xem thêm <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($rejectedWishes) }}</h3>
                            <p>Tổng số nguyện vọng bị loại</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('wishes.index')}}" class="small-box-footer">
                            Xem thêm <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--end::Container-->
    </div>
    <!--end::App Content-->

@endsection
