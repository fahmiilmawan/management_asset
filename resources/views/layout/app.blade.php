<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @livewireStyles
</head>

<body>
    <!-- Header -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block" style="font-size: 20px">Management Asset</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="d-none d-md-block dropdown-toggle ps-2">Selamat Datang, {{ Auth::user()->nama_lengkap }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->nama_lengkap }}</h6>
                            <span>{{ Auth::user()->role }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('setting-profile', Auth::user()->id) }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @if (Auth::user()->role == 'administrator' || Auth::user()->role == 'admin_umum')
            <!-- Master Data -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#master-data-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Master Data</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="master-data-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('index.barang') }}">
                            <i class="bi bi-circle"></i><span>Data Barang</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.ruangan') }}">
                            <i class="bi bi-circle"></i><span>Data Ruangan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.unit') }}">
                            <i class="bi bi-circle"></i><span>Data Unit</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 'administrator')
                    <li>
                        <a href="{{ route('index.user') }}">
                            <i class="bi bi-circle"></i><span>Data User</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            @if (Auth::user()->role == 'administrator' || Auth::user()->role == 'admin_umum')
            <!-- Data Asset -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#data-asset-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Data Asset</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="data-asset-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('index.asset') }}">
                            <i class="bi bi-circle"></i><span>Data Asset</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.scanqr') }}">
                            <i class="bi bi-circle"></i><span>Scan QR Code</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            {{-- Data Laporan --}}

            <!-- Pengaduan & Pengadaan -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#complaint-procurement-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Pengaduan & Pengadaan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="complaint-procurement-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('index.pengaduan') }}">
                            <i class="bi bi-circle"></i><span>Pengaduan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.pengadaan') }}">
                            <i class="bi bi-circle"></i><span>Pengadaan</span>
                        </a>
                    </li>
                </ul>
            </li>
            @if (Auth::user()->role == 'administrator' || Auth::user()->role == 'admin_umum')

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#data-laporan-asset" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Data Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="data-laporan-asset" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('index.laporan-asset') }}">
                            <i class="bi bi-circle"></i><span>Laporan Keseluruhan Asset</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.laporan-pengadaan') }}">
                            <i class="bi bi-circle"></i><span>Laporan Pengadaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('index.laporan-pengaduan') }}">
                            <i class="bi bi-circle"></i><span>Laporan Pengaduan</span>
                        </a>
                    </li>
                </ul>
            </li>

            @endif
        </ul>
    </aside><!-- End Sidebar -->

    <!-- ======= Main Content ======= -->
    <main id="main" class="main">
        <!-- Page Content -->
        @yield('main-content')
    </main><!-- End Main Content -->

    <footer id="footer" class="footer">
        <div class="copyright">
          © Copyright <strong><span>{{ date('Y') }}</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          Created by <a href="">IT</a>
        </div>
      </footer>
    @livewireScripts

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <!-- Lightbox2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2/dist/css/lightbox.min.css" rel="stylesheet">

<!-- Lightbox2 JS -->
<script src="https://cdn.jsdelivr.net/npm/lightbox2/dist/js/lightbox.min.js"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    @stack('script')
</body>

</html>
