<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title')</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
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
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <!--end::Required Plugin(AdminLTE)-->

    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous">

    <!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body navbar-fixed">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <p href="#" class="nav-link">{{ Auth::user()->hoten }} ({{ Auth::user()->cccd }})</p>
                    </li>
                </ul>

            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-light shadow" data-bs-theme="light">
            <div class="sidebar-brand d-flex align-items-center ">
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                    <!-- Logo -->
                    <img src="{{ asset('assets/img/logo.png') }}" alt="VMU Logo" style="height: 46px; width: auto;"
                        class="me-2">

                    <!-- Tên trường -->
                    <div class="d-flex flex-column">
                        <span class="fw-bold text-primary" style="font-size: 14px;">
                            TRƯỜNG ĐẠI HỌC HÀNG HẢI VIỆT NAM
                        </span>
                        <span class="text-muted text-center" style="font-size: 12px;">
                            VIETNAM MARITIME UNIVERSITY
                        </span>
                    </div>
                </a>
            </div>

            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            @if (Auth::user()->role == 0)
                <div class="sidebar-wrapper">
                    <nav class="mt-2">
                        <!--begin::Sidebar Menu-->
                        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link active">
                                    <i class="nav-icon fa-solid fa-gauge-high"></i>
                                    <p class="fw-bold">
                                        Trang chủ
                                    </p>
                                </a>

                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile') }}" class="nav-link ">
                                    <i class="nav-icon fa-solid fa-user"></i>
                                    <p class="fw-bold">
                                        Thông tin thí sinh
                                    </p>
                                </a>

                            </li>

                            <li class="nav-item">
                                <a href="{{ route('registerWishes')}}" class="nav-link ">
                                    {{-- <i class="nav-icon fa-solid fa-user"></i> --}}
                                    <i class="nav-icon fas fa-registered"></i>
                                    <p class="fw-bold">
                                        Đăng ký xét tuyển
                                    </p>
                                </a>

                            </li>


                             <li class="nav-item">
                                <a href="" class="nav-link ">
                                    <i class="nav-icon fas fa-chart-bar"></i>
                                    <p class="fw-bold">
                                        Kết quả xét tuyển
                                    </p>
                                </a>

                            </li>

                            <li class="nav-header">TÀI KHOẢN</li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <p class="fw-bold">ĐĂNG XUẤT</p>
                                </a>
                            </li>
                        </ul>
                        <!--end::Sidebar Menu-->
                    </nav>
                </div>
            @elseif(Auth::user()->role == 1)
                <div class="sidebar-wrapper">
                    <nav class="mt-2">
                        <!--begin::Sidebar Menu-->
                        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <i class="nav-icon fa-solid fa-gauge-high"></i>
                                    <p class="fw-bold">
                                        Trang chủ
                                    </p>
                                </a>

                            </li>
                            <li class="nav-item">
                                <a href="{{ url('dao-tao/majors') }}" class="nav-link {{ request()->is('dao-tao/majors*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-square-poll-vertical"></i>
                                    <p class="fw-bold">Quản lý chuyên ngành</p>
                                </a>
                            </li>

                            <li class="nav-item"> 
                                <a href="{{ route('candidates.index') }}" class="nav-link {{ request()->routeIs('candidates.index') ? 'active' : '' }}">
                                    <i class="fa-solid fa-square-poll-vertical"></i>
                                    <p class="fw-bold">Quản lý hồ sơ thí sinh</p>
                                </a>
                            </li>

                             <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-square-poll-vertical"></i>
                                    <p class="fw-bold">Quản lý nguyện vọng</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-square-poll-vertical"></i>
                                    <p class="fw-bold">Quản lý kết quả xét tuyển</p>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a href="{{ route('xettuyen')}}" class="nav-link">
                                    <i class="fa-solid fa-square-poll-vertical"></i>
                                    <p class="fw-bold">Xét tuyển thí sinh</p>
                                </a>
                            </li> --}}

                            <li class="nav-header">TÀI KHOẢN</li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <p class="fw-bold">ĐĂNG XUẤT</p>
                                </a>
                            </li>
                        </ul>
                        <!--end::Sidebar Menu-->
                    </nav>
                </div>
            @else
                <div class="sidebar-wrapper">
                    <nav class="mt-2">
                        <!--begin::Sidebar Menu-->
                        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route('account') }}" class="nav-link ">
                                    <i class="nav-icon fa-solid fa-user"></i>
                                    <p class="fw-bold">
                                        Quản lý tài khoản
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link active">
                                    <i class="nav-icon fa-solid fa-gauge-high"></i>
                                    <p class="fw-bold">
                                        Thống kê
                                    </p>
                                </a>

                            </li>

                            <li class="nav-header">TÀI KHOẢN</li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <p class="fw-bold">ĐĂNG XUẤT</p>
                                </a>
                            </li>
                        </ul>
                        <!--end::Sidebar Menu-->
                    </nav>
                </div>
            @endif

            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">

            @yield('content')
        </main>
        <!--end::App Main-->
        <!--begin::Footer-->
        <footer class="app-footer">

            <strong>
                Copyright &copy; {{ NOW()->year }}
                <a href="#">TRƯỜNG ĐẠI HỌC HÀNG HẢI VIỆT NAM</a>.
            </strong>

        </footer>
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
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
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                timer: 4000,
                showConfirmButton: false
            });
        </script> @endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-NRZchBuHZWSXldqrtAOeCZpucH/1n1ToJ3C8mSK95NU=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };

        document.addEventListener("DOMContentLoaded", function() {
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

    <!-- OPTIONAL SCRIPTS -->

    <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
        integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script>

    <!-- sortablejs -->
    <script>
        const connectedSortables =
            document.querySelectorAll(".connectedSortable");
        connectedSortables.forEach((connectedSortable) => {
            let sortable = new Sortable(connectedSortable, {
                group: "shared",
            });
        });

        const cardHeaders = document.querySelectorAll(
            ".connectedSortable .card-header"
        );
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = "move";
        });
    </script>

    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>

    <!-- ChartJS -->
    <script>
        // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
        // IT'S ALL JUST JUNK FOR DEMO
        // ++++++++++++++++++++++++++++++++++++++++++

        const sales_chart_options = {
            series: [{
                    name: "Digital Goods",
                    data: [28, 48, 40, 19, 86, 27, 90],
                },
                {
                    name: "Electronics",
                    data: [65, 59, 80, 81, 56, 55, 40],
                },
            ],
            chart: {
                height: 300,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ["#0d6efd", "#20c997"],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                type: "datetime",
                categories: [
                    "2023-01-01",
                    "2023-02-01",
                    "2023-03-01",
                    "2023-04-01",
                    "2023-05-01",
                    "2023-06-01",
                    "2023-07-01",
                ],
            },
            tooltip: {
                x: {
                    format: "MMMM yyyy",
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector("#revenue-chart"),
            sales_chart_options
        );
        sales_chart.render();
    </script>

    <!-- jsvectormap -->
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script>

    <!-- jsvectormap -->
    <script>
        const visitorsData = {
            US: 398, // USA
            SA: 400, // Saudi Arabia
            CA: 1000, // Canada
            DE: 500, // Germany
            FR: 760, // France
            CN: 300, // China
            AU: 700, // Australia
            BR: 600, // Brazil
            IN: 800, // India
            GB: 320, // Great Britain
            RU: 3000, // Russia
        };

        // World map by jsVectorMap
        const map = new jsVectorMap({
            selector: "#world-map",
            map: "world",
        });

        // Sparkline charts
        const option_sparkline1 = {
            series: [{
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline1 = new ApexCharts(
            document.querySelector("#sparkline-1"),
            option_sparkline1
        );
        sparkline1.render();

        const option_sparkline2 = {
            series: [{
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline2 = new ApexCharts(
            document.querySelector("#sparkline-2"),
            option_sparkline2
        );
        sparkline2.render();

        const option_sparkline3 = {
            series: [{
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            }, ],
            chart: {
                type: "area",
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: "straight",
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ["#DCE6EC"],
        };

        const sparkline3 = new ApexCharts(
            document.querySelector("#sparkline-3"),
            option_sparkline3
        );
        sparkline3.render();
    </script>
    @yield('script')
    <!--end::Script-->
</body><!--end::Body-->

</html>
