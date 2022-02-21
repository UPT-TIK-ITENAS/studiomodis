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
                        <h3 class="mb-0 fw-bold text-white">Peminjaman Alat</h3>
                    </div>
                    <div>
                        <button class="btn btn-white" id="btn-cart" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Alat <span id="cart-count">({{ $cart->count() }})</span>
                        </button>
                        @if ($cart->count() > 0)
                            <a href="{{ route('user.peminjaman.ruangan.confirm') }}" class="btn btn-info text-white">
                                Konfirmasi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-6">
                        <div class="d-flex align-items-center">
                            <div class="">
                                <a href="{{ route('user.peminjaman.ruangan.create') }}" class="btn btn-sm btn-primary"><i
                                        class="fas fa-arrow-left me-1"></i>Kembali</a>
                            </div>
                            <div class="ps-3">
                                <h4 class="mb-1">Tabel Alat</h4>
                                <p>Alat yang tersedia periode tanggal {{ $peminjaman_ruangan['begin_date'] }} hingga
                                    {{ $peminjaman_ruangan['end_date'] }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table" id="alat-table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Aksi</th>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table" id="cart-table" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let flashdatasukses = $('.success-session').data('flashdata');
            if (flashdatasukses) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: flashdatasukses,
                    type: 'success'
                })
            }
            let flashdatadanger = $('.danger-session').data('flashdata');
            if (flashdatadanger) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: flashdatadanger,
                    type: 'error'
                })
            }
        })
        let table = $('#alat-table').DataTable({
            fixedHeader: true,
            pageLength: 25,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.peminjaman.ruangan.alat_list', 'alat') }}",
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
                    data: 'photo',
                    name: 'photo'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        function reload_table(callback, resetPage = false) {
            table.ajax.reload(callback, resetPage); //reload datatable ajax 
        }

        $('#alat-table').on('click', '.stock', function(e) {
            let id = $(this).data('id')
            let nama = $(this).data('nama')
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            e.preventDefault();

            (async () => {

                const {
                    value: text
                } = await Swal.fire({
                    title: name,
                    text: 'Masukkan Quantity',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Look up',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                })

                if (text) {
                    $.ajax({
                        url: "{{ url('peminjaman/ruangan/alat_cart') }}/" + id,
                        type: 'POST',
                        data: {
                            _token: CSRF_TOKEN,
                            qty: text
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    type: 'success',
                                    title: "Berhasil Memasukkan Data Ke Keranjang",
                                    showConfirmButton: true
                                }).then((result) => {
                                    location.reload()
                                })
                                $("#cart-count").html(`(${response.data})`)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    type: 'error',
                                    title: response.message,
                                    showConfirmButton: true
                                })
                            }
                            console.log(response)
                            reload_table(null, true)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                type: 'error',
                                title: 'Error saat memasukkan data',
                                showConfirmButton: true
                            })
                        }
                    })
                }

            })()
        })
        var exampleModalEl = document.getElementById('exampleModal')
        let cartTable = $('#cart-table').DataTable({
            fixedHeader: true,
            pageLength: 25,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.peminjaman.ruangan.alat_list', 'cart') }}",
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
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        exampleModalEl.addEventListener('show.bs.modal', function(event) {
            cartTable.ajax.reload(null, false)
        })
    </script>
@endpush
