@extends('layouts.application')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="card mb-3">
                <div class="card-title py-3">
                    Profile
                </div>
            </div>
            @if (session('success'))
                <div class="success-session" data-flashdata="{{ session('success') }}"></div>
            @endif
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0 fw-bold text-white">Edit Profile</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 mt-6">
            <div class="card">
                <div class="card-body">
                    <div class=" mb-6">
                        <h4 class="mb-1">Edit Profile</h4>
                    </div>
                    <div>
                        <form action="{{ route('profile.update') }}" method="post">
                            @csrf
                            @method('PUT')
                            <!-- row -->
                            <div class="mb-3 row">
                                <label for="namapegawai"
                                    class="col-sm-3
                                  col-form-label form-label">Nama
                                    Pegawai</label>

                                <div class="col-md-9 col-12">
                                    <input type="text" class="form-control @error('namapegawai') is-invalid @enderror"
                                        placeholder="Nama Pegawai" name="namapegawai" id="namapegawai"
                                        value="{{ $user->namapegawai }}" required>
                                    @error('namapegawai')
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
                                        placeholder="Password" id="password" name="password" value="{{ $user->password }}"
                                        required>
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
                                        placeholder="Email" id="email" name="email" value="{{ $user->email }}" required>
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
                                        placeholder="Nomor HP" id="nohp" name="nohp" value="{{ $user->nohp }}" required>
                                    @error('nohp')
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

                                <div class="col-md-9 col-12  mb-2 mb-lg-0">
                                    <input type="text" class="form-control @error('idtelegram') is-invalid @enderror"
                                        placeholder="ID Telegram" id="idtelegram" name="idtelegram"
                                        value="{{ $user->idtelegram }}">
                                    @error('idtelegram')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
        })
    </script>
@endpush
