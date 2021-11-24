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
                        <h3 class="mb-0 fw-bold text-white">Kategori Alat</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Buat Kategori</h4>
                    </div>
                    <div>
                        <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <!-- row -->
                            <div class="row align-items-center">
                                <label for="nama"
                                    class="col-sm-3
                                  col-form-label form-label">Nama
                                    Kategori</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Nama kategori" name="nama" id="nama"
                                        value="{{ old('nama') ?? $kategori->nama }}" required>
                                    @error('nama')
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
