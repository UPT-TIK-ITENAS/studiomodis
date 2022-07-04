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
                        <h3 class="mb-0 fw-bold text-white">Konsultasi</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            @if (session('success'))
                <div class="success-session" data-flashdata="{{ session('success') }}"></div>
            @elseif(session('danger'))
                <div class="danger-session" data-flashdata="{{ session('danger') }}"></div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Buat Data Konsultasi</h4>
                    </div>
                    <div>
                        <form action="{{ route('user.konsultasi.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-3 col-form-label form-label">Status</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <select id="status" name="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" @if (old('status') == 1) selected @endif>Pre-Production
                                        </option>
                                        <option value="2" @if (old('status') == 2) selected @endif>Production
                                        </option>
                                        <option value="3" @if (old('status') == 3) selected @endif>Post-Production
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
                                <label for="subjek" class="col-sm-3 col-form-label form-label">Subjek</label>

                                <div class="col-md-9 col-12">
                                    <input id="subjek" class="form-control @error('subjek') is-invalid @enderror"
                                        type="text" name="subjek" placeholder="Masukkan subjek"
                                        value="{{ old('subjek') }}" required>
                                    @error('subjek')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="materi"
                                    class="col-sm-3
                                  col-form-label form-label">Materi</label>

                                <div class="col-md-9 col-12">
                                    <input type="file" class="form-control dropify" placeholder="Materi" name="materi"
                                        id="materi" data-allowed-file-extensions="pdf" required>
                                    @error('materi')
                                        <span class="text-danger fw-bold" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <label for="deskripsi"
                                    class="col-sm-3
                                  col-form-label form-label">Deskripsi</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" cols="30"
                                        rows="10" required>{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- list -->
                                <div class="offset-md-3 col-md-9 col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            let flashdatasukses = $('.success-session').data('flashdata');
            if (flashdatasukses) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: flashdatasukses,
                    type: 'success'
                })
            }
            let flashdatagagal = $('.danger-session').data('flashdata');
            if (flashdatagagal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: flashdatagagal,
                    type: 'error'
                })
            }
            $("#status").select2({
                placeholder: "- Pilih Salah Satu -",
                theme: "bootstrap-5",
            })
        })
        $('.dropify').dropify()
    </script>
@endpush
