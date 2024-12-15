<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img') }}/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>
        Dashboard
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }} " rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css" rel="stylesheet" />
    <style>

    </style>

    @livewireStyles

</head>

<body class="g-sidenav-show  bg-gray-100">
    {{-- Sidebar --}}
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand px-4 py-3 m-0"
                href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
                <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26"
                    height="26" alt="main_logo">
                <span class="ms-1 text-sm text-dark">Management Asset</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2">
        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                {{-- Side Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ route('dashboard') }}">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                {{-- End Side Dashboard --}}
                {{-- Side Master Data --}}
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Master Data</h6>
                </li>
                <li class="nav-item mt-3">
                    <a class="nav-link {{ Request::is('barang','ruangan','unit') ? 'active bg-gradient-dark text-white' : 'text-dark' }} text-dark" data-bs-toggle="collapse" href="#masterDataMenu" role="button"
                        aria-expanded="false" aria-controls="masterDataMenu">
                        <i class="material-symbols-rounded opacity-5">category</i>
                        <span class="nav-link-text ms-1">Master Data</span>
                    </a>
                    <div class="collapse ps-4" id="masterDataMenu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('index.barang') }}">
                                    <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                                    <span class="nav-link-text ms-1">Data Barang</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('index.ruangan') }}">
                                    <i class="material-symbols-rounded opacity-5">receipt_long</i>
                                    <span class="nav-link-text ms-1">Data Ruangan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href={{ route('index.unit') }}>
                                    <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                                    <span class="nav-link-text ms-1">Data Unit</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('index.user') }}">
                                    <i class="material-symbols-rounded opacity-5">person</i>
                                    <span class="nav-link-text ms-1">Data User</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- End Side Master Data --}}
                    {{-- Side Data Asset --}}
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Data Asset</h6>
                </li>
                <a class="nav-link text-dark" data-bs-toggle="collapse" href="#dataAssetMenu" role="button"
                    aria-expanded="false" aria-controls="masterDataMenu">
                    <i class="material-symbols-rounded opacity-5">category</i>
                    <span class="nav-link-text ms-1">Data Asset</span>
                </a>
                <div class="collapse ps-4" id="dataAssetMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('index.asset')  }}">
                                <i class="material-symbols-rounded opacity-5">person</i>
                                <span class="nav-link-text ms-1">Data Asset</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('index.scanqr')  }}">
                                <i class="material-symbols-rounded opacity-5">camera</i>
                                <span class="nav-link-text ms-1">Scan QR Code</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- End Side Data Asset --}}
                {{-- Side Laporan Pengaduan --}}
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Pengaduan &
                        Pengajuan</h6>
                </li>
                <a class="nav-link  {{ Request::is('pengaduan') ? 'active bg-gradient-dark text-white' : 'text-dark' }} text-dark" data-bs-toggle="collapse" href="#pengaduanPengadaan" role="button"
                    aria-expanded="false" aria-controls="pengadaanPengaduan">
                    <i class="material-symbols-rounded opacity-5">category</i>
                    <span class="nav-link-text ms-1">Pengaduan & Pengadaan</span>
                </a>
                <div class="collapse ps-4" id="pengaduanPengadaan">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('index.pengaduan') }}">
                                <i class="material-symbols-rounded opacity-5">person</i>
                                <span class="nav-link-text ms-1">Pengaduan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('index.pengadaan') }}">
                                <i class="material-symbols-rounded opacity-5">person</i>
                                <span class="nav-link-text ms-1">Pengadaan</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- End Side Laporan Pengaduan --}}
            </ul>
        </div>
    </aside>
    {{-- End Of Sidebar --}}
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">


        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 py-3 my-3 shadow-sm" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <div class="collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4" id="navbar">
                    <ul class="navbar-nav d-flex align-items-center ms-auto justify-content-end">  <!-- Add ms-auto and justify-content-end here -->
                        <li class="nav-item d-xl-none ps-3 mx-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                        <!-- Account Logo and Dropdown -->
                        <li class="nav-item dropdown ps-3 mx-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="navbarProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://placehold.co/400" class="avatar avatar-sm rounded-circle me-2" alt="user-profile">
                                <span class="d-sm-inline d-none">
                                    Hi, {{ Auth::user()->nama_lengkap }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="navbarProfileDropdown">
                                <li>
                                    <a class="dropdown-item border-radius-md" href="#">
                                        <i class="material-symbols-rounded me-2 opacity-6">account_circle</i>
                                        Profil
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item border-radius-md">
                                            <i class="material-symbols-rounded me-2 opacity-6">logout</i>
                                            Sign Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



        <!-- End Navbar -->

        {{-- Main Content --}}
        @yield('main-content')


        {{-- End Main Content --}}
        </div>
    </main>


    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/livewire"></script>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets/') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets/') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets/') }}/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/') }}/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>
