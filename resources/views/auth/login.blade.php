<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/x-icon" href=" {{ asset('assets/images/favicon/favicon.ico') }}">

    <!-- Libs CSS -->

    <link rel="stylesheet" href=" {{ asset('assets/libs/prismjs/themes/prism.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/prismjs/plugins/line-numbers/prism-line-numbers.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/prismjs/plugins/toolbar/prism-toolbar.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href=" {{ asset('assets/libs/dropzone/dist/dropzone.css') }}">
    <link href=" {{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href=" {{ asset('assets/css/theme.min.css') }}">
    <title>Login | Studio Modis</title>
</head>

<body>
    <!-- container -->
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0
        min-vh-100">
            <div class="col-12 col-md-8 col-lg-6 col-xxl-4 py-8 py-xl-0">
                <!-- Card -->
                <div class="card smooth-shadow-md">
                    <!-- Card body -->
                    <div class="card-body p-6">
                        <div class="mb-4">
                            <a href="#">
                                <h1>STUDIO MODIS</h1>
                            </a>
                            <p class="mb-6">Masukkan username dan password sesuai akun yang telah ditentukan
                            </p>
                        </div>
                        <!-- Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    placeholder="Username" required>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="**************" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- Checkbox -->
                            <div class="d-lg-flex justify-content-between align-items-center
                  mb-4">
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                            </div>
                            <div>
                                <!-- Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Sign
                                        in</button>
                                </div>
                            </div>


                        </form>
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

    <!-- Theme JS -->
    <script src=" {{ asset('assets/js/theme.min.js') }}"></script>
</body>

</html>
