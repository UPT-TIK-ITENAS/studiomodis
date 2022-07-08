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
                        <h4 class="mb-1">Show Data Konsultasi</h4>
                    </div>
                    <div>
                        <form>
                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-3 col-form-label form-label">Status</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <p>{{ $status }}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="subjek" class="col-sm-3 col-form-label form-label">Subjek</label>

                                <div class="col-md-9 col-12">
                                    <p>{{ $konsultasi->subjek }}</p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="materi"
                                    class="col-sm-3
                                  col-form-label form-label">Materi</label>

                                <div class="col-md-9 col-12">
                                    <a href="{{ asset('assets/materi/' . $konsultasi->materi) }}" target="_blank"
                                        id="materi" class="btn btn-primary">Lihat
                                        Materi</a>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="materi"
                                    class="col-sm-3
                                  col-form-label form-label">PIC</label>

                                <div class="col-md-9 col-12">
                                    @if ($pic == null)
                                        <p>-</p>
                                    @else
                                        <p>{{ $pic->namapegawai }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <label for="deskripsi"
                                    class="col-sm-3
                                  col-form-label form-label">Deskripsi</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <p>{{ $konsultasi->deskripsi }}</p>
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
            $("#status, #pic").select2({
                placeholder: "- Pilih Salah Satu -",
                theme: "bootstrap-5",
            })
        })
        $('.dropify').dropify()
    </script>
@endpush
