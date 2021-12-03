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
                        <h3 class="mb-0 fw-bold text-white">Peminjaman Alat</h3>
                    </div>
                    <div>
                        <a href="" class="btn btn-white">Keranjang <span id="cart-count">({{ $cart->count() }})</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Tabel Alat</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="alat-table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
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
    <script>
        let table = $('#alat-table').DataTable({
            fixedHeader: true,
            pageLength: 25,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.peminjaman.ruangan.alat_list') }}",
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
            // Swal.fire({
            //     title: 'Apakah Yakin?',
            //     text: `Apakah Anda yakin ingin menghapus ruangan dengan nama ${nama}`,
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Hapus'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            //         $.ajax({
            //             url: "{{ url('admin/ruangan') }}/" + id,
            //             type: 'POST',
            //             data: {
            //                 _token: CSRF_TOKEN,
            //                 _method: "delete",
            //             },
            //             dataType: 'JSON',
            //             success: function(response) {
            //                 Swal.fire(
            //                     'Deleted!',
            //                     `Ruangan ${nama} berhasil terhapus.`,
            //                     'success'
            //                 )
            //                 reload_table(null, true)
            //             },
            //             error: function(jqXHR, textStatus, errorThrown) {
            //                 Swal.fire({
            //                     icon: 'error',
            //                     type: 'error',
            //                     title: 'Error saat delete data',
            //                     showConfirmButton: true
            //                 })
            //             }
            //         })
            //     }
            // })

            // const {
            //     value: qty
            // } = Swal.fire({
            //     title: name,
            //     text: 'Masukkan Quantity',
            //     input: 'text',
            //     inputAttributes: {
            //         autocapitalize: 'off'
            //     },
            //     showCancelButton: true,
            //     confirmButtonText: 'Look up',
            //     showLoaderOnConfirm: true,
            //     allowOutsideClick: () => !Swal.isLoading()
            // })
            // if (qty) {
            //     $.ajax({
            //         url: "{{ url('user/ruangan/alat') }}/" + id + "/cart",
            //         type: 'POST',
            //         data: {
            //             _token: CSRF_TOKEN,
            //         },
            //         dataType: 'JSON',
            //         success: function(response) {
            //             console.log(response)
            //             reload_table(null, true)
            //         },
            //         error: function(jqXHR, textStatus, errorThrown) {
            //             Swal.fire({
            //                 icon: 'error',
            //                 type: 'error',
            //                 title: 'Error saat memasukkan data',
            //                 showConfirmButton: true
            //             })
            //         }
            //     })
            // }

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
                                })
                                $("#cart-count").html("{{ $cart->count() }}")
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
    </script>
@endpush
