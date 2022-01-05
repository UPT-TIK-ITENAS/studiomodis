@extends('layouts.application')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            @if (session('success'))
                <div class="success-session" data-flashdata="{{ session('success') }}"></div>
            @elseif(session('danger'))
                <div class="danger-session" data-flashdata="{{ session('danger') }}"></div>
            @endif
            <!-- Page header -->
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white">Peminjaman</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class="mt-4">
                        <h4 class="mb-1">Detail Peminjaman</h4>
                    </div>

                    <div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Nomor Surat</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $borrow->nomor_surat }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Status</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                @if ($borrow->status == 0)
                                    <span class="badge rounded-pill bg-warning">
                                        Menunggu
                                    </span>
                                @elseif($borrow->status == 1)
                                    <span class="badge rounded-pill bg-success">
                                        Disetujui
                                    </span>
                                @elseif($borrow->status == 2)
                                    <span class="badge rounded-pill bg-danger">
                                        Tidak Disetujui
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if ($borrow->status == 2)
                            <div class="mb-3 row align-items-center">
                                <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Pesan Tolak</label>
                                <div class="col-md-9 col-12 col-form-label form-label">
                                    <p class="mb-0 text-danger fw-bold">
                                        {{ $borrow->pesan_tolak }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Deskripsi</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">{{ $borrow->description }}</p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Tanggal Awal</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $borrow->begin_date }}</p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Tanggal Akhir</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $borrow->end_date }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="mb-1">Detail Ruangan</h4>
                    </div>

                    <div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Ruangan</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $borrow->ruangan[0]->nama }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Nomor Ruangan</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $borrow->ruangan[0]->no_ruangan }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Deskripsi Ruangan</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $borrow->ruangan[0]->deskripsi }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="mb-1">Detail Alat</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="alat-table" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let alatTable = $('#alat-table').DataTable({
            fixedHeader: true,
            pageLength: 25,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.peminjaman.ruangan.alat_show', $borrow->id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
            ]
        });
    </script>
@endpush
