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
                        <h3 class="mb-0 fw-bold text-white">Buat Peminjaman Ruangan</h3>
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
                        <h4 class="mb-1">Buat Peminjaman Ruangan</h4>
                    </div>
                    <div>
                        <form action="{{ route('admin.peminjaman.ruangan.store') }}" method="post" autocomplete="false">
                            @csrf
                            <!-- row -->
                            <div class="mb-3 row align-items-center">
                                <label for="id_ruangan"
                                    class="col-sm-3
                                  col-form-label form-label">Pilih
                                    Ruangan</label>
                                <div class="col-md-9 col-12 mb-2 mb-lg-0">
                                    <select id="id_ruangan" name="id_ruangan"
                                        class="form-control @error('id_ruangan') is-invalid
                                    @enderror">
                                        <option></option>
                                        @foreach ($ruangan as $r)
                                            <option value="{{ $r->id }}" @if (old('id_ruangan') == $r->id) selected @endif>{{ $r->nama }}
                                                - {{ $r->no_ruangan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_ruangan')
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
                                  col-form-label form-label">Tanggal
                                    Awal</label>

                                <div class="col-md-9 col-12">
                                    <input id="begin_date" class="form-control @error('begin_date') is-invalid @enderror"
                                        type="text" name="begin_date" placeholder="Masukkan tanggal awal"
                                        value="{{ old('begin_date') }}" required>
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
                                        value="{{ old('end_date') }}" required>
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
                                    <input id="jam_awal" class="form-control @error('jam_awal') is-invalid @enderror"
                                        type="time" name="jam_awal" placeholder="Masukkan tanggal akhir"
                                        value="{{ old('jam_awal') }}" required>
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
                                    <input id="jam_akhir" class="form-control @error('jam_akhir') is-invalid @enderror"
                                        type="time" name="jam_akhir" placeholder="Masukkan tanggal akhir"
                                        value="{{ old('jam_akhir') }}" required>
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
                                        placeholder="Deskripsi Ruangan" id="description" name="description" required>
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
                        <div class="mt-5 row">
                            <label for="no_ruangan"
                                class="col-sm-3
                              col-form-label form-label">Jadwal
                                Ruangan</label>
                        </div>
                        <div class="mt-5 row">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-4">
                        <h4 class="mb-1">Detail Peminjaman</h4>
                    </div>
                    <div>
                        <div class="mb-3 row align-items-center">
                            <label for="nomor_surat" class="col-sm-3 col-form-label form-label">Nomor Surat</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0" id="detail_nomor_surat">

                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="description" class="col-sm-3 col-form-label form-label">Deskripsi</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0" id="detail_description">

                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="begin_date" class="col-sm-3 col-form-label form-label">Tanggal Awal</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0" id="detail_begin_date">
                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="end_date" class="col-sm-3 col-form-label form-label">Tanggal Akhir</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0" id="detail_end_date">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="mb-1">Detail Ruangan</h4>
                    </div>

                    <div>
                        <div class="mb-3 row align-items-center">
                            <label for="ruangan_nama" class="col-sm-3 col-form-label form-label">Ruangan</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0" id="detail_ruangan_nama">
                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="nomor_ruangan" class="col-sm-3 col-form-label form-label">Nomor Ruangan</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0" id="detail_ruangan_nomor">
                                </p>
                            </div>
                        </div>
                        <div class="mb-3 row align-items-center">
                            <label for="ruangan_deskripsi" class="col-sm-3 col-form-label form-label">Deskripsi
                                Ruangan</label>
                            <div class="col-md-9 col-12 col-form-label form-label">
                                <p class="mb-0" id="detail_ruangan_deskripsi">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="mb-1">Detail Alat</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="alat-table" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">

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
@endpush

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
            $("#id_ruangan").select2({
                placeholder: "- Pilih Salah Satu -",
                theme: "bootstrap-5",
            })
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
        let ruangan = null;
        $("#id_ruangan").on("select2:select", function(e) {
            ruangan = $(e.currentTarget).val();
            console.log(ruangan)
            loadCalendarEvents(ruangan)
        });
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        document.addEventListener('DOMContentLoaded', function() {
            loadCalendarEvents(ruangan)
        });

        const loadCalendarEvents = (ruangan) => {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    center: 'dayGridMonth,timeGridWeek'
                },
                initialView: 'dayGridMonth',
                eventSources: [{
                    url: `${window.baseurl}/check-ruangan`,
                    method: 'GET',
                    extraParams: {
                        ruangan
                    },
                    failure: function() {
                        alert('there was an error while fetching events!');
                    },
                }],
                eventClick: function(info) {
                    console.log(info.event.id)
                    let id = info.event.id
                    $.ajax({
                        url: "{{ url('check-borrow') }}/" + id,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response)
                            $("#detail_nomor_surat").html(response.nomor_surat)
                            $("#detail_description").html(response.description)
                            $("#detail_begin_date").html(response.begin_date)
                            $("#detail_end_date").html(response.end_date)
                            $("#detail_ruangan_nama").html(response.ruangan[0].nama)
                            $("#detail_ruangan_nomor").html(response.ruangan[0].no_ruangan)
                            $("#detail_ruangan_deskripsi").html(response.ruangan[0].deskripsi)
                            let responseHTML = '';
                            for (let index = 0; index < response.alat.length; index++) {
                                responseHTML += `
                            <tr>
                                <td class="">${index+1}</td>
                                <td class="">${response.alat[index].nama}</td>
                                <td class="">${response.alat[index].pivot.qty}</td>
                            </tr>
                            `
                            }
                            $("#table-body").html(responseHTML)
                            var myModal = new bootstrap.Modal(document.getElementById(
                                'exampleModal'))
                            myModal.toggle()
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                icon: 'error',
                                type: 'error',
                                title: 'Error saat melihat data',
                                showConfirmButton: true
                            })
                        }
                    })

                }
            });
            calendar.setOption('locale', 'id');
            calendar.render();
        }
    </script>
@endpush
