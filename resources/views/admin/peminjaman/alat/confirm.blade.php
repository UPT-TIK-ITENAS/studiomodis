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
                        <h3 class="mb-0 fw-bold text-white">Konfirmasi Peminjaman</h3>
                    </div>
                    <div>
                        <form action="{{ route('admin.peminjaman.ruangan.confirmStore') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success text-white">
                                Selesai
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Detail Ruangan</h4>
                    </div>

                    <div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Deskripsi</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">{{ $peminjaman['description'] }}</p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Tanggal Awal</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $peminjaman['begin_date'] . ' ' . $peminjaman['jam_awal'] }}</p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="id_ruangan" class="col-sm-3 col-form-label form-label">Tanggal Akhir</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0">
                                    {{ $peminjaman['end_date'] . ' ' . $peminjaman['jam_akhir'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class=" mb-6">
                        <h4 class="mb-1">Detail Alat</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="cart-table" style="width: 100% !important;">
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
        let cartTable = $('#cart-table').DataTable({
            fixedHeader: true,
            pageLength: 25,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.peminjaman.ruangan.alat_list', 'confirm') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
            ]
        });
    </script>
@endpush
