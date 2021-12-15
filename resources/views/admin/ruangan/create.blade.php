@extends('layouts.application')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="card mb-3">
                <div class="card-title py-3">
                    {{ Breadcrumbs::render('admin.ruangan.create') }}
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white">Ruangan</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Buat Ruangan</h4>
                    </div>
                    <div>
                        <form action="{{ route('admin.ruangan.store') }}" method="post">
                            @csrf
                            <!-- row -->
                            <div class="mb-3 row">
                                <label for="nama"
                                    class="col-sm-3
                                  col-form-label form-label">Nama
                                    Ruangan</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Nama ruangan" name="nama" id="nama" required>
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- row -->
                            <div class="mb-3 row">
                                <label for="no_ruangan"
                                    class="col-sm-3
                                  col-form-label form-label">Nomor
                                    Ruangan</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('no_ruangan') is-invalid @enderror"
                                        placeholder="Nomor Ruangan" id="no_ruangan" name="no_ruangan" required>
                                    @error('no_ruangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_ruangan"
                                    class="col-sm-3
                                  col-form-label form-label">Deskripsi</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                        placeholder="Deskripsi Ruangan" id="deskripsi" name="deskripsi" required>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row align-items-center">
                                <label for="status"
                                    class="col-sm-3
                                  col-form-label form-label">Status</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <select id="status" name="status"
                                        class="form-control @error('status') is-invalid
                                    @enderror">
                                        <option></option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- list -->
                                <div class="offset-md-3 col-md-9 col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


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
            $("#status").select2({
                placeholder: "- Pilih Salah Satu -",
                theme: "bootstrap-5",
            })
        })
    </script>
@endpush
