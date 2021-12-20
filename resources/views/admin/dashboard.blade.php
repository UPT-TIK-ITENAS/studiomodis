@extends('layouts.application')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="card mb-3">
                <div class="card-title py-3">
                    {{ Breadcrumbs::render('admin.home') }}
                </div>
            </div>
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
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Alat</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $alat }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $alat_dipinjam }}</span>Alat yang
                            dipinjam hari ini</p>
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
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Ruangan</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $ruangan }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $ruangan_dipinjam }}</span>Ruangan yang
                            dipinjam hari ini</p>
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
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Peminjaman</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $peminjaman }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $peminjaman_diterima }}</span>Peminjaman
                            yang telah diterima
                        </p>
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
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Pengguna</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-bullseye fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $pengguna }}</h1>
                        <p class="mb-0">Pengguna yang terdaftar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')

@endpush
