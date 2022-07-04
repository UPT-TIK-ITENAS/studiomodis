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
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white">Data Konsultasi</h3>
                    </div>
                    <div>
                        <a href="{{ route('admin.konsultasi.create') }}" class="btn btn-white">Buat Konsultasi</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Tabel Konsultasi</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="konsultasi-table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Pengguna</th>
                                    <th scope="col">Subjek</th>
                                    <th scope="col">PIC</th>
                                    <th scope="col">Dibuat</th>
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

@push('modal')
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row align-items-center">
                            <label for="status" class="col-sm-3 col-form-label form-label">Status</label>
                            <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option>- Pilih -
                                    </option>
                                    <option value="1">Pre-Production
                                    </option>
                                    <option value="2">Production
                                    </option>
                                    <option value="3">Post-Production
                                    </option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="subjek" class="col-sm-3 col-form-label form-label">Penguna</label>

                            <div class="col-md-9 col-12">
                                <input id="subjek" class="form-control @error('subjek') is-invalid @enderror" type="text"
                                    name="subjek" placeholder="Masukkan subjek" value="{{ old('subjek') }}" disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="subjek" class="col-sm-3 col-form-label form-label">Subjek</label>

                            <div class="col-md-9 col-12">
                                <input id="subjek" class="form-control @error('subjek') is-invalid @enderror" type="text"
                                    name="subjek" placeholder="Masukkan subjek" value="{{ old('subjek') }}" disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="materi"
                                class="col-sm-3
                              col-form-label form-label">Materi</label>

                            <div class="col-md-9 col-12">
                                <a href="#" target="_blank" id="materi" class="btn btn-primary">Lihat Materi</a>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="deskripsi"
                                class="col-sm-3
                              col-form-label form-label">Deskripsi</label>
                            <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" cols="30"
                                    rows="10" disabled></textarea>

                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="deskripsi"
                                class="col-sm-3
                              col-form-label form-label">PIC</label>
                            <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                <select id="pic" name="pic" class="form-control">
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="saveBtn" name="saveBtn" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
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
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        })
        let table = $('#konsultasi-table').DataTable({
            fixedHeader: true,
            pageLength: 25,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.konsultasi.list') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'user.username',
                    name: 'user.username'
                },
                {
                    data: 'subjek',
                    name: 'subjek'
                },
                {
                    data: 'pic_text',
                    name: 'pic_text'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
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

        $('#konsultasi-table').on('click', '.hapus_record', function(e) {
            let id = $(this).data('id')
            let subjek = $(this).data('subjek')
            e.preventDefault()
            Swal.fire({
                title: 'Apakah Yakin?',
                text: `Apakah Anda yakin ingin menghapus konsultasi dengan subjek ${subjek}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('admin/konsultasi') }}/" + id,
                        type: 'POST',
                        data: {
                            _method: "delete",
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                `Konsultasi ${subjek} berhasil terhapus.`,
                                'success'
                            )
                            reload_table(null, true)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                type: 'error',
                                title: 'Error saat delete data',
                                showConfirmButton: true
                            })
                        }
                    })
                }
            })
        })

        $('body').on('click', '.edit_record', function() {
            id = $(this).data('id');
            console.log(id)
            $.get("{{ url('/admin/konsultasi') }}/" + id, function(response) {
                $('#editModal').modal('show');
                let data = response.konsultasi
                let status = $("#status").val(data.status)
                let subjek = $("#subjek").val(data.subjek)
                let deskripsi = $("#deskripsi").val(data.deskripsi)
                let materi = $("#materi").attr('href', `${window.baseurl}/assets/materi/${data.materi}`)
                if (data.pic != null) {
                    $("#pic").html(`<option value="${data.pic.id}">${data.pic.username}</option>`)
                }
                console.log(data);
            })
            $("#pic").select2({
                placeholder: "- Pilih Salah Satu -",
                allowClear: true,
                theme: "bootstrap-5",
                dropdownParent: $(`#editModal`),
                ajax: {
                    url: `${window.baseurl}/admin/konsultasi/pic`,
                    dataType: "json",
                    data: function(params) {
                        return {
                            search: params.term,
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response,
                        };
                    },
                    cache: true,
                },
            });
        });
        $("#saveBtn").on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('/admin/konsultasi') }}/" + id,
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    _method: 'PUT',
                    pic: $('#pic').val(),
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Updated!',
                            `Konsultasi berhasil diupdate.`,
                            'success'
                        ).then((result) => {
                            reload_table(null, true)
                            $('#editModal').modal('hide');
                        })
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        type: 'error',
                        title: 'Error saat update data',
                        showConfirmButton: true
                    })
                }
            })
        })
    </script>
@endpush
