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
    @stack('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href=" {{ asset('assets/css/theme.min.css') }}">

    <title>Homepage | Dash Ui - Bootstrap 5 Admin Dashboard Template</title>
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
                <a class="navbar-brand" href="./index.html">
                    <img src=" {{ asset('assets/images/brand/logo/logo.svg') }}" alt="" />
                </a>
                <!-- Navbar nav -->
                <ul class="navbar-nav flex-column" id="sideNavbar">
                    <li class="nav-item">
                        <a class="nav-link has-arrow  active " href="./index.html">
                            <i data-feather="home" class="nav-icon icon-xs me-2"></i> Dashboard
                        </a>

                    </li>


                    <!-- Nav item -->
                    <li class="nav-item">
                        <div class="navbar-heading">Layouts & Pages</div>
                    </li>


                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse"
                            data-bs-target="#navPages" aria-expanded="false" aria-controls="navPages">
                            <i data-feather="layers" class="nav-icon icon-xs me-2">
                            </i> Pages
                        </a>

                        <div id="navPages" class="collapse " data-bs-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link " href="./pages/profile.html">
                                        Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link has-arrow   " href="./pages/settings.html">
                                        Settings
                                    </a>

                                </li>


                                <li class="nav-item">
                                    <a class="nav-link " href="./pages/billing.html">
                                        Billing
                                    </a>
                                </li>




                                <li class="nav-item">
                                    <a class="nav-link " href="./pages/pricing.html">
                                        Pricing
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./pages/404-error.html">
                                        404 Error
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </li>


                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse"
                            data-bs-target="#navAuthentication" aria-expanded="false" aria-controls="navAuthentication">
                            <i data-feather="lock" class="nav-icon icon-xs me-2">
                            </i> Authentication
                        </a>
                        <div id="navAuthentication" class="collapse " data-bs-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link " href="./pages/sign-in.html"> Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  " href="./pages/sign-up.html"> Sign Up</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./pages/forget-password.html">
                                        Forget Password
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="./pages/layout.html">
                            <i data-feather="sidebar" class="nav-icon icon-xs me-2">
                            </i>
                            Layouts
                        </a>
                    </li>

                    <!-- Nav item -->
                    <li class="nav-item">
                        <div class="navbar-heading">UI Components</div>
                    </li>

                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse"
                            data-bs-target="#navComponents" aria-expanded="false" aria-controls="navComponents">
                            <i data-feather="database" class="nav-icon icon-xs me-2">
                            </i> Components
                        </a>
                        <div id="navComponents" class="collapse " data-bs-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/accordions.html" aria-expanded="false">
                                        Accordions
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/alerts.html" aria-expanded="false">
                                        Alerts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/badge.html" aria-expanded="false">
                                        Badge
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/breadcrumb.html" aria-expanded="false">
                                        Breadcrumb
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/button.html" aria-expanded="false">
                                        Button
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="./components/button-group.html"
                                        aria-expanded="false">
                                        Button group
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/card.html" aria-expanded="false">
                                        Card
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/carousel.html" aria-expanded="false">
                                        Carousel
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/collapse.html" aria-expanded="false">
                                        Collapse
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/dropdowns.html" aria-expanded="false">
                                        Dropdowns
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/forms.html" aria-expanded="false">
                                        Forms
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/input-group.html"
                                        aria-expanded="false">
                                        Input group
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/list-group.html" aria-expanded="false">
                                        List group
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " href="./components/modal.html" aria-expanded="false">
                                        Modal
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/navs.html" aria-expanded="false">
                                        Navs
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/navbar.html" aria-expanded="false">
                                        Navbar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/offcanvas.html" aria-expanded="false">
                                        Offcanvas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/pagination.html" aria-expanded="false">
                                        Pagination
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/popovers.html" aria-expanded="false">
                                        Popovers
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/progress.html" aria-expanded="false">
                                        Progress
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./components/scrollspy.html" aria-expanded="false">
                                        Scrollspy
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/spinners.html" aria-expanded="false">
                                        Spinners
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/toasts.html" aria-expanded="false">
                                        Toasts
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="./components/tooltips.html" aria-expanded="false">
                                        Tooltips
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="./pages/tables.html">
                            <i class="nav-icon icon-xs me-2 bi bi-table">
                            </i>
                            Tables
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse"
                            data-bs-target="#navMenuLevel" aria-expanded="false" aria-controls="navMenuLevel">
                            <i data-feather="corner-left-down" class="nav-icon icon-xs me-2">
                            </i> Menu Level
                        </a>
                        <div id="navMenuLevel" class="collapse " data-bs-parent="#sideNavbar">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link has-arrow " href="#!" data-bs-toggle="collapse"
                                        data-bs-target="#navMenuLevelSecond" aria-expanded="false"
                                        aria-controls="navMenuLevelSecond">
                                        Two Level
                                    </a>
                                    <div id="navMenuLevelSecond" class="collapse" data-bs-parent="#navMenuLevel">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link " href="#!"> NavItem 1</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " href="#!"> NavItem 2</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link has-arrow  collapsed  " href="#!" data-bs-toggle="collapse"
                                        data-bs-target="#navMenuLevelThree" aria-expanded="false"
                                        aria-controls="navMenuLevelThree">
                                        Three Level
                                    </a>
                                    <div id="navMenuLevelThree" class="collapse " data-bs-parent="#navMenuLevel">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link  collapsed " href="#!" data-bs-toggle="collapse"
                                                    data-bs-target="#navMenuLevelThreeOne" aria-expanded="false"
                                                    aria-controls="navMenuLevelThreeOne">
                                                    NavItem 1
                                                </a>
                                                <div id="navMenuLevelThreeOne" class="collapse collapse "
                                                    data-bs-parent="#navMenuLevelThree">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item">
                                                            <a class="nav-link " href="#!">
                                                                NavChild Item 1
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link " href="#!"> Nav Item 2</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Nav item -->
                    <li class="nav-item">
                        <div class="navbar-heading">Documentation</div>
                    </li>

                    <!-- Nav item -->
                    <li class="nav-item">
                        <a class="nav-link has-arrow " href="./docs/index.html">
                            <i data-feather="clipboard" class="nav-icon icon-xs me-2">
                            </i> Docs
                        </a>
                    </li>




                </ul>

            </div>
        </nav>
        <!-- Page content -->
        <div id="page-content">
            <div class="header @@classList">
                <!-- navbar -->
                <nav class="navbar-classic navbar navbar-expand-lg">
                    <a id="nav-toggle" href="#"><i data-feather="menu" class="nav-icon me-2 icon-xs"></i></a>
                    <div class="ms-lg-3 d-none d-md-none d-lg-block">
                        <!-- Form -->
                        <form class="d-flex align-items-center">
                            <input type="search" class="form-control" placeholder="Search" />
                        </form>
                    </div>
                    <!--Navbar nav -->
                    <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">

                        <!-- List -->
                        <li class="dropdown ms-2">
                            <a class="rounded-circle" href="#" role="button" id="dropdownUser"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-md avatar-indicators avatar-online">
                                    <img alt="avatar" src=" {{ asset('assets/images/avatar/avatar-1.jpg') }}"
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
                                        <a class="dropdown-item" href="#">
                                            <i class="me-2 icon-xxs dropdown-item-icon" data-feather="user"></i>Edit
                                            Profile
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
            <div class="bg-primary pt-10 pb-21"></div>
            <div class="container-fluid mt-n22 px-6">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <!-- Page header -->
                        <div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mb-2 mb-lg-0">
                                    <h3 class="mb-0 fw-bold text-white">Projects</h3>
                                </div>
                                <div>
                                    <a href="#" class="btn btn-white">Create New Project</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- heading -->
                                <div
                                    class="d-flex justify-content-between align-items-center
                    mb-3">
                                    <div>
                                        <h4 class="mb-0">Projects</h4>
                                    </div>
                                    <div
                                        class="icon-shape icon-md bg-light-primary text-primary
                      rounded-1">
                                        <i class="bi bi-briefcase fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <div>
                                    <h1 class="fw-bold">18</h1>
                                    <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- heading -->
                                <div
                                    class="d-flex justify-content-between align-items-center
                    mb-3">
                                    <div>
                                        <h4 class="mb-0">Active Task</h4>
                                    </div>
                                    <div
                                        class="icon-shape icon-md bg-light-primary text-primary
                      rounded-1">
                                        <i class="bi bi-list-task fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <div>
                                    <h1 class="fw-bold">132</h1>
                                    <p class="mb-0"><span class="text-dark me-2">28</span>Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- heading -->
                                <div
                                    class="d-flex justify-content-between align-items-center
                    mb-3">
                                    <div>
                                        <h4 class="mb-0">Teams</h4>
                                    </div>
                                    <div
                                        class="icon-shape icon-md bg-light-primary text-primary
                      rounded-1">
                                        <i class="bi bi-people fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <div>
                                    <h1 class="fw-bold">12</h1>
                                    <p class="mb-0"><span class="text-dark me-2">1</span>Completed</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
                        <!-- card -->
                        <div class="card rounded-3">
                            <!-- card body -->
                            <div class="card-body">
                                <!-- heading -->
                                <div
                                    class="d-flex justify-content-between align-items-center
                    mb-3">
                                    <div>
                                        <h4 class="mb-0">Productivity</h4>
                                    </div>
                                    <div
                                        class="icon-shape icon-md bg-light-primary text-primary
                      rounded-1">
                                        <i class="bi bi-bullseye fs-4"></i>
                                    </div>
                                </div>
                                <!-- project number -->
                                <div>
                                    <h1 class="fw-bold">76%</h1>
                                    <p class="mb-0"><span class="text-success me-2">5%</span>Completed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- clipboard -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    @stack('scripts')

    <!-- Theme JS -->
    <script src=" {{ asset('assets/js/theme.min.js') }}"></script>

</body>

</html>
