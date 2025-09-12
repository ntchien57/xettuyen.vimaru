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
           
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->

@endsection
