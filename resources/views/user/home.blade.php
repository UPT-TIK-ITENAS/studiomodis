@extends('layouts.application')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white">Peminjaman</h3>
                    </div>
                    <div>
                        <a href="#" class="btn btn-white">Buat</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card rounded-3">
                    <!-- card body -->
                    <div class="card-body text-center">
                        <h1>Peminjaman Ruangan</h1>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h4 class="text-success">Disetujui</h4>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">{{ $peminjaman_ruangan_s }}</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h4 class="text-warning">Menunggu</h4>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning">{{ $peminjaman_ruangan_m }}</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h4 class="text-danger">Ditolak</h4>
                            </div>
                            <div class="col-6">
                                <h4 class="text-danger">{{ $peminjaman_ruangan_t }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 mt-6">
                <!-- card -->
                <div class="card rounded-3">
                    <!-- card body -->
                    <div class="card-body text-center">
                        <h1>Peminjaman Alat</h1>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h4 class="text-success">Disetujui</h4>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">{{ $peminjaman_alat_s }}</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h4 class="text-warning">Menunggu</h4>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning">{{ $peminjaman_alat_m }}</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <h4 class="text-danger">Ditolak</h4>
                            </div>
                            <div class="col-6">
                                <h4 class="text-danger">{{ $peminjaman_alat_t }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('scripts')

@endpush
