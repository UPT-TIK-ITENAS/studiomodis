<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href=" {{ asset('assets/images/favicon/favicon.ico') }}">

    <!-- Libs CSS -->

    <link rel="stylesheet" href=" {{ asset('assets/libs/prismjs/themes/prism.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/prismjs/plugins/line-numbers/prism-line-numbers.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/prismjs/plugins/toolbar/prism-toolbar.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/dropzone/dist/dropzone.css') }}">
    <link href=" {{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-html5-1.7.1/b-print-1.7.1/fh-3.1.9/r-2.2.9/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css"
        integrity="sha256-zsz1FbyNCtIE2gIB+IyWV7GbCLyKJDTBRz0qQaBSLxM=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href=" {{ asset('assets/css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <title>Homepage | Studio Modis</title>
    <script>
        window.baseurl = "{{ url('') }}"
    </script>
</head>

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <!-- Sidebar -->
        <nav class="navbar-vertical navbar">
            <div class="nav-scroller">
                <!-- Brand logo -->
                <a class="navbar-brand" href="{{ route('admin.home') }}">
                    <p>SIMODIS</p>
                </a>
                <!-- Navbar nav -->
                <ul class="navbar-nav flex-column" id="sideNavbar">
                    @if (auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link has-arrow  active " href="{{ route('admin.home') }}">
                                <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                            </a>

                        </li>

                        <!-- Nav item -->
                        <li class="nav-item">
                            <div class="navbar-heading">Admin</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.sumber-daya.index') }}">
                                <i data-feather="file" class="nav-icon icon-xs me-2">
                                </i>
                                Sumber Daya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.user.index') }}">
                                <i data-feather="users" class="nav-icon icon-xs me-2">
                                </i>
                                Pegawai
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.ruangan.index') }}">
                                <i data-feather="sidebar" class="nav-icon icon-xs me-2">
                                </i>
                                Ruangan
                            </a>
                        </li>

                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse"
                                data-bs-target="#navPages" aria-expanded="false" aria-controls="navPages">
                                <i data-feather="layers" class="nav-icon icon-xs me-2">
                                </i> Alat
                            </a>

                            <div id="navPages" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ route('admin.kategori.index') }}">
                                            Kategori Alat
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ route('admin.alat.index') }}">
                                            Alat
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        @php
                            $ruangan = App\Borrow::with(['ruangan'])
                                ->whereHas('ruangan')
                                ->where('status', 0)
                                ->count();
                            $alat = App\Borrow::with(['alat'])
                                ->whereHas('alat')
                                ->whereDoesntHave('ruangan')
                                ->where('status', 0)
                                ->count();
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse"
                                data-bs-target="#nav-peminjaman" aria-expanded="false"
                                aria-controls="nav-peminjaman">
                                <i data-feather="book" class="nav-icon icon-xs me-2">
                                </i> Peminjaman
                                @if ($ruangan + $alat > 0)
                                    <span
                                        class="ms-2 badge rounded-pill bg-warning text-dark">{{ $ruangan + $alat }}</span>
                                @endif
                            </a>

                            <div id="nav-peminjaman" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ route('admin.peminjaman.ruangan.index') }}">
                                            Ruangan
                                            @if ($ruangan > 0)
                                                <span
                                                    class="ms-2 badge rounded-pill bg-warning text-dark">{{ $ruangan }}</span>
                                            @endif
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ route('admin.peminjaman.alat.index') }}">
                                            Alat
                                            @if ($alat > 0)
                                                <span
                                                    class="ms-2 badge rounded-pill bg-warning text-dark">{{ $alat }}</span>
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('admin.konsultasi.index') }}">
                                <i data-feather="bookmark" class="nav-icon icon-xs me-2">
                                </i>
                                Konsultasi
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link has-arrow  active " href="{{ route('user.home') }}">
                                <i data-feather="home" class="nav-icon icon-xs me-2"></i> Homepage
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse"
                                data-bs-target="#nav-peminjaman" aria-expanded="false"
                                aria-controls="nav-peminjaman">
                                <i data-feather="book" class="nav-icon icon-xs me-2">
                                </i> Peminjaman
                            </a>

                            <div id="nav-peminjaman" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ route('user.peminjaman.ruangan.index') }}">
                                            Ruangan
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " href="{{ route('user.peminjaman.alat.index') }}">
                                            Alat
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow" href="{{ route('user.konsultasi.index') }}">
                                <i data-feather="bookmark" class="nav-icon icon-xs me-2"></i> Konsultasi
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
        </nav>
        <!-- Page content -->
        <div id="page-content">
            <div class="header @@classList">
                <!-- navbar -->
                <nav class="navbar-classic navbar navbar-expand-lg">
                    <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>
                    <!--Navbar nav -->
                    <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">

                        <!-- List -->
                        <li class="dropdown ms-2">
                            <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-md avatar-indicators avatar-online">
                                    <img alt="avatar" src=" {{ asset('assets/images/avatar/avatar-user.png') }}"
                                        class="rounded-circle" />
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                                <div class="px-4 pb-0 pt-2">


                                    <div class="lh-1 ">
                                        <h5 class="mb-1"> {{ Auth::user()->username }}</h5>
                                        <a href="#" class="text-inherit fs-6">View my profile</a>
                                    </div>
                                    <div class=" dropdown-divider mt-3 mb-2"></div>
                                </div>

                                <ul class="list-unstyled">

                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit
                                            Profile
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="power"></i>Sign
                                            Out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Container fluid -->
            <div class="pt-10 pb-21"
                style="background: #4e54c8;
            background: -webkit-linear-gradient(to right, #4e54c8, #8f94fb);
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            ">
            </div>
            <div class="container-fluid mt-n22 px-6">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('modal')

    <!-- Scripts -->
    <!-- Libs JS -->
    <script src=" {{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/prismjs/components/prism-core.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/prismjs/components/prism-markup.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/prismjs/plugins/line-numbers/prism-line-numbers.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src=" {{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-html5-1.7.1/b-print-1.7.1/fh-3.1.9/r-2.2.9/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.5/dist/sweetalert2.all.min.js"
        integrity="sha256-NHQE05RR3vZ0BO0PeDxbN2N6dknQ7Z4Ch4Vfijn9Y+0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"
        integrity="sha256-XOMgUu4lWKSn8CFoJoBoGd9Q/OET+xrfGYSo+AKpFhE=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"
        integrity="sha256-GcByKJnun2NoPMzoBsuCb4O2MKiqJZLlHTw3PJeqSkI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    @stack('scripts')
    <script src=" {{ asset('assets/js/theme.min.js') }}"></script>

</body>

</html>
