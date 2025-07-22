<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>VIMARU</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Login Page">
    <meta name="author" content="ColorlibHQ">
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/styles/overlayscrollbars.min.css"
        integrity="sha256-LWLZPJ7X1jJLI5OG5695qDemW1qQ7lNdbTfQ64ylbUY=" crossorigin="anonymous">
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Font Awesome)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css"
        integrity="sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=" crossorigin="anonymous">
    <!--end::Third Party Plugin(Font Awesome)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('css/adminlte.css')}}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--end::Required Plugin(AdminLTE)-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="login-page bg-body-secondary"
    style="background: url('{{ asset('assets/img/bg-login.png') }}') no-repeat center center; background-size: cover;">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>
            <p class="flex items-center justify-center fs-5 fw-bold mt-3 text-primary">TRƯỜNG ĐẠI HỌC HÀNG HẢI VIỆT NAM
            </p>
            <p class="flex items-center justify-center fs-5 fw-bold text-danger">CỔNG ĐĂNG KÝ VÀ XÉT TUYỂN ĐẠI HỌC CHÍNH
                QUY</p>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg fw-bold fs-5">Đăng Nhập</p>

                <form id="loginForm" method="post" action="../index3.html" novalidate>
                    <div class="input-group mb-2">
                        <input type="number" class="form-control" placeholder="Căn cước công dân" id="cccd"
                            onchange="validateCCCD()">
                        <div class="input-group-text">
                            <span class="fa-solid fa-user"></span>
                        </div>
                    </div>
                    <div class="text-danger mb-3" id="cccd-error" style="display: none; font-size: 0.9rem;"></div>

                    <div class="input-group mb-2 mt-3">
                        <input type="password" class="form-control" placeholder="Mật khẩu" id="password"
                            onchange="validatePassword()">
                        <div class="input-group-text">
                            <span class="fa-solid fa-lock"></span>
                        </div>
                    </div>
                    <div class="text-danger mb-3" id="password-error" style="display: none; font-size: 0.9rem;"></div>

                    <div class="social-auth-links text-center mb-3 d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">
                            Đăng nhập
                        </button>
                    </div>

                    <div class="social-auth-links text-center mb-3 d-grid gap-2">
                        <p style="opacity: 0.5; font-size: 12px;" class="text-secondary">―――――――― HOẶC ――――――――</p>

                        <p class="">Nếu bạn chưa có tài khoản? <a href="{{ route('register')}}">Đăng ký tại đây</a></p>

                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                timer: 4000,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- /.login-box -->

    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-NRZchBuHZWSXldqrtAOeCZpucH/1n1ToJ3C8mSK95NU=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        function validateCCCD() {
            const cccd = document.getElementById('cccd').value.trim();
            const error = document.getElementById('cccd-error');
            if (cccd === '') {
                error.innerText = 'Vui lòng nhập Căn cước công dân.';
                error.style.display = 'block';
                return false;
            } else if (cccd.length !== 12) {
                error.innerText = 'CCCD phải đủ 12 số.';
                error.style.display = 'block';
                return false;
            } else {
                error.innerText = '';
                error.style.display = 'none';
                return true;
            }
        }

        function validatePassword() {
            const password = document.getElementById('password').value.trim();
            const error = document.getElementById('password-error');
            if (password === '') {
                error.innerText = 'Vui lòng nhập mật khẩu.';
                error.style.display = 'block';
                return false;
            } else {
                error.innerText = '';
                error.style.display = 'none';
                return true;
            }
        }

        // Kiểm tra toàn form khi submit
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            const validCCCD = validateCCCD();
            const validPassword = validatePassword();

            if (!validCCCD || !validPassword) {
                e.preventDefault(); // Ngăn không cho submit
            }
        });
    </script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };

        document.addEventListener("DOMContentLoaded", function () {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!--end::Script-->
</body><!--end::Body-->

</html>