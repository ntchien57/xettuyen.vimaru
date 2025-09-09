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
                        <div class="row mb-3">
                            <a class="btn btn-warning">Các nguyện vọng của bạn đang trong qua trình xét tuyển vui lòng đợi kết quả sớm nhất</a>
                        </div>

                    </div>
                </div>
        </div>
    </div>
@endsection

@section('script')
   
@endsection
