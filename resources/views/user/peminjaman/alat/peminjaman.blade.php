@extends('layouts.application')

@push('styles')
    <style>
        input[type="time"] {
            padding-right: 30px;
        }

        input[type="time"]:invalid+span.validity:after {
            content: '❌';

        }

        input[type="time"]:valid+span.validity:after {
            content: "✔️";
        }

    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white">Buat Peminjaman Alat</h3>
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
                        <h4 class="mb-1">Buat Peminjaman Alat</h4>
                        <p>Batas jam awal <b>tidak boleh kurang dari jam 08:00</b>, sedangkan jam akhir
                            <b>tidak boleh lebih dari jam 17:00</b>
                        </p>
                    </div>
                    @php
                        $peminjaman = session()->get('peminjaman_' . auth()->user()->id);
                    @endphp
                    <div>
                        <form action="{{ route('user.peminjaman.alat.storePeminjaman') }}" method="post">
                            @csrf
                            <!-- row -->
                            <div class="mb-3 row">
                                <label for="no_ruangan"
                                    class="col-sm-3
                                  col-form-label form-label">Tanggal
                                    Awal</label>
                                <div class="col-md-9 col-12">
                                    <input id="begin_date" class="form-control @error('begin_date') is-invalid @enderror"
                                        type="text" name="begin_date" placeholder="Masukkan tanggal awal"
                                        value="{{ old('begin_date') ?? $peminjaman ? $peminjaman['begin_date'] : null }}"
                                        required>
                                    @error('begin_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_ruangan"
                                    class="col-sm-3
                                  col-form-label form-label">Tanggal
                                    Akhir</label>

                                <div class="col-md-9 col-12">
                                    <input id="end_date" class="form-control @error('end_date') is-invalid @enderror"
                                        type="text" name="end_date" placeholder="Masukkan tanggal akhir"
                                        value="{{ old('end_date') ?? $peminjaman ? $peminjaman['end_date'] : null }}"
                                        required>
                                    @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_ruangan"
                                    class="col-sm-3
                                  col-form-label form-label">Jam
                                    Awal</label>

                                <div class="col-md-9 col-12">
                                    <div class="d-flex align-items-center">
                                        <input id="jam_awal" class="form-control @error('jam_awal') is-invalid @enderror"
                                            type="time" name="jam_awal" placeholder="Masukkan tanggal akhir"
                                            value="{{ old('jam_awal') ?? $peminjaman ? $peminjaman['jam_awal'] : null }}"
                                            min="08:00" max="16:00" required>
                                        <span class="validity ps-3"></span>
                                    </div>
                                    @error('jam_awal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_ruangan"
                                    class="col-sm-3
                                  col-form-label form-label">Jam
                                    Akhir</label>

                                <div class="col-md-9 col-12">
                                    <div class="d-flex align-items-center">
                                        <input id="jam_akhir" class="form-control @error('jam_akhir') is-invalid @enderror"
                                            type="time" name="jam_akhir" placeholder="Masukkan tanggal akhir"
                                            value="{{ old('jam_akhir') ?? $peminjaman ? $peminjaman['jam_akhir'] : null }}"
                                            min="09:00" max="17:00" required>
                                        <span class="validity ps-3"></span>
                                    </div>
                                    @error('jam_akhir')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="row align-items-center">
                                <label for="status"
                                    class="col-sm-3
                                  col-form-label form-label">Deskripsi</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Deskripsi peminjaman" id="description"
                                        value="{{ old('description') ?? $peminjaman ? $peminjaman['description'] : null }}"
                                        name="description" required>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- list -->
                                <div class="offset-md-3 col-md-9 col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Lanjutkan</button>
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
            $('#begin_date, #end_date').on('keydown keyup change', function(e) {
                e.preventDefault();
                return false;
            })

            $("#begin_date").datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date) {
                    let day = date.getDay();
                    return [(day != 0), ''];
                },
                minDate: +1
            });

            $('#end_date').datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date) {
                    let day = date.getDay();
                    return [(day != 0), ''];
                },
                minDate: +1,
                beforeShow: function(input, inst) {
                    let minDate = $('#begin_date').datepicker('getDate');
                    $('#end_date').datepicker('option', 'minDate', minDate);
                },

            })
        })
    </script>
@endpush
