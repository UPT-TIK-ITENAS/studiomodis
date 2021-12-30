@extends('layouts.application')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="card mb-3">
                <div class="card-title py-3">
                    {{ Breadcrumbs::render('admin.user.create') }}
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white">Pegawai</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Buat Pegawai</h4>
                    </div>
                    <div>
                        <form action="{{ route('admin.user.store') }}" method="post">
                            @csrf
                            <!-- row -->
                            <div class="mb-3 row">
                                <label for="namapegawai"
                                    class="col-sm-3
                                  col-form-label form-label">Nama
                                    Pegawai</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('namapegawai') is-invalid @enderror"
                                        placeholder="Nama Pegawai" name="namapegawai" id="namapegawai" required>
                                    @error('namapegawai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- row -->
                            <div class="mb-3 row">
                                <label for="nik"
                                    class="col-sm-3
                                  col-form-label form-label">NIP</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        placeholder="Nomor Pegawai" id="nik" name="nik" required>
                                    @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password"
                                    class="col-sm-3
                                  col-form-label form-label">Password</label>

                                <div class="col-md-9 col-12">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password" id="password" name="password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email"
                                    class="col-sm-3
                                  col-form-label form-label">Email</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" id="email" name="email" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nohp"
                                    class="col-sm-3
                                  col-form-label form-label">Nomor
                                    HP</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('nohp') is-invalid @enderror"
                                        placeholder="Nomor HP" id="nohp" name="nohp" required>
                                    @error('nohp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="unit"
                                    class="col-sm-3
                                  col-form-label form-label">Unit</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <select id="unit" name="unit"
                                        class="form-control @error('unit') is-invalid
                                    @enderror">
                                        <option value=""></option>
                                        @foreach ($unit as $u)
                                            <option value="{{ $u->idunit }}">{{ $u->namaunit }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jabatan"
                                    class="col-sm-3
                                  col-form-label form-label">Jabatan</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <select id="jabatan" name="jabatan"
                                        class="form-control @error('jabatan') is-invalid
                                    @enderror">
                                        <option value=""></option>
                                        @foreach ($jabatan as $j)
                                            <option value="{{ $j->idjabatan }}">{{ $j->namajabatan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="idtelegram"
                                    class="col-sm-3
                                  col-form-label form-label">ID
                                    Telegram</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('idtelegram') is-invalid @enderror"
                                        placeholder="ID Telegram" id="idtelegram" name="idtelegram">
                                    @error('idtelegram')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="no_user"
                                    class="col-sm-3
                                  col-form-label form-label">Atasan
                                    1</label>

                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <select id="atasan_1" name="atasan_1"
                                        class="form-control @error('atasan_1') is-invalid
                                    @enderror">
                                    </select>
                                    @error('atasan_1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row align-items-center">
                                <label for="atasan_2"
                                    class="col-sm-3
                                  col-form-label form-label">Atasan
                                    2</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <select id="atasan_2" name="atasan_2"
                                        class="form-control @error('atasan_2') is-invalid
                                    @enderror">
                                    </select>
                                    @error('atasan_2')
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
            $("#jabatan, #unit").select2({
                placeholder: "- Pilih Salah Satu -",
                theme: "bootstrap-5",
            })
            $('#atasan_1, #atasan_2').select2({
                placeholder: "- Pilih Salah Satu -",
                theme: "bootstrap-5",
                ajax: {
                    url: "{{ route('admin.user.atasan') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        })
    </script>
@endpush
