@extends('layouts.application')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="card mb-3">
                <div class="card-title py-3">
                    {{ Breadcrumbs::render('admin.home') }}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Alat</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $alat }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $alat_dipinjam }}</span>Alat yang
                            dipinjam hari ini</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Ruangan</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $ruangan }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $ruangan_dipinjam }}</span>Ruangan yang
                            dipinjam hari ini</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Peminjaman</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $peminjaman }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $peminjaman_diterima }}</span>Peminjaman
                            yang telah diterima
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card rounded-3">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
    mb-3">
                        <div>
                            <h4 class="mb-0">Pengguna</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
      rounded-1">
                            <i class="bi bi-bullseye fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $pengguna }}</h1>
                        <p class="mb-0">Pengguna yang terdaftar</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12 mt-3">
            <!-- Page header -->
            <div class="card mb-3">
                <div class="card-title row ps-5 py-3">
                    <div class="col-sm-6">
                        <h4>Grafik Peminjaman Ruangan</h4>
                    </div>
                    <div class="col-sm-6 pe-5">
                        <select name="select_grafik_ruangan" id="select_grafik_ruangan" class="form-control">
                            @foreach ($year as $y)
                                <option value="{{ $y->tahun }}" @if ($y->tahun == Carbon\Carbon::now()->year) selected @endif>{{ 'Tahun ' . $y->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart"></div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-title row ps-5 py-3">
                    <div class="col-sm-6">
                        <h4>Grafik Peminjaman Alat</h4>
                    </div>
                    <div class="col-sm-6 pe-5">
                        <select name="select_grafik_alat" id="select_grafik_alat" class="form-control">
                            @foreach ($year as $y)
                                <option value="{{ $y->tahun }}" @if ($y->tahun == Carbon\Carbon::now()->year) selected @endif>{{ 'Tahun ' . $y->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart-alat"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        var optPeminjamanPerMonth = {
            annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled: false
            },
            chart: {
                type: 'bar',
                height: 500
            },
            fill: {
                opacity: 1
            },
            plotOptions: {},
            series: [{
                name: 'Total',
                data: []
            }],
            title: {
                text: 'Grafik Peminjaman Ruangan Per Bulan',
                offsetX: 15,
                style: {
                    fontSize: '20px',
                    fontWeight: 'bold',
                },
            },
            subtitle: {
                text: 'Tahun 2021',
                offsetX: 15,
                style: {
                    fontSize: '14px',
                    fontWeight: 'normal',
                },
            },
            noData: {
                text: "Tidak Ada ... ",
                align: 'center',
                verticalAlign: 'middle',
                offsetX: 0,
                offsetY: 0,
                style: {
                    fontSize: '20px',
                    fontFamily: 'Nunito'
                }
            },
            colors: ['#435ebe', '#ff7976'],
            xaxis: {
                categories: [],
                tickPlacement: 'on'
            },
            toolbar: {
                show: true,
                offsetX: 0,
                offsetY: 0,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true,
                    customIcons: []
                },
                autoSelected: 'zoom'
            },
        }
        var optPeminjamanAlatPerMonth = {
            annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled: false
            },
            chart: {
                type: 'bar',
                height: 500
            },
            fill: {
                opacity: 1
            },
            plotOptions: {},
            series: [{
                name: 'Total',
                data: []
            }],
            title: {
                text: 'Grafik Peminjaman Alat Per Bulan',
                offsetX: 15,
                style: {
                    fontSize: '20px',
                    fontWeight: 'bold',
                },
            },
            subtitle: {
                text: 'Tahun 2021',
                offsetX: 15,
                style: {
                    fontSize: '14px',
                    fontWeight: 'normal',
                },
            },
            noData: {
                text: "Tidak Ada ... ",
                align: 'center',
                verticalAlign: 'middle',
                offsetX: 0,
                offsetY: 0,
                style: {
                    fontSize: '20px',
                    fontFamily: 'Nunito'
                }
            },
            colors: ['#435ebe', '#ff7976'],
            xaxis: {
                categories: [],
                tickPlacement: 'on'
            },
            toolbar: {
                show: true,
                offsetX: 0,
                offsetY: 0,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true,
                    customIcons: []
                },
                autoSelected: 'zoom'
            },
        }
        var options = {
            series: [{
                name: 'Peter',
                data: [5, 5, 10, 8, 7, 5, 4, null, null, null, 10, 10, 7, 8, 6, 9]
            }, {
                name: 'Johnny',
                data: [10, 15, null, 12, null, 10, 12, 15, null, null, 12, null, 14, null, null, null]
            }, {
                name: 'David',
                data: [null, null, null, null, 3, 4, 1, 3, 4, 6, 7, 9, 5, null, null, null]
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                },
                animations: {
                    enabled: false
                }
            },
            stroke: {
                width: [5, 5, 4],
                curve: 'straight'
            },
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
            title: {
                text: 'Missing data (null values)'
            },
            xaxis: {},
        };

        var chartPeminjamanRuanganPerMonth = new ApexCharts(document.querySelector("#chart"),
            optPeminjamanPerMonth);
        var chartPeminjamanAlatPerMonth = new ApexCharts(document.querySelector("#chart-alat"),
            optPeminjamanAlatPerMonth);
        // var chart = new ApexCharts(document.querySelector("#chart"), options);

        chartPeminjamanRuanganPerMonth.render();
        chartPeminjamanAlatPerMonth.render();
        // chart.render();

        let year = new Date().getFullYear()
        getPeminjamanPerMonth(chartPeminjamanRuanganPerMonth, 'ruangan', year)
        getPeminjamanPerMonth(chartPeminjamanAlatPerMonth, 'alat', year)

        let select_grafik_ruangan = document.getElementById("select_grafik_ruangan")
        select_grafik_ruangan.addEventListener('change', (e) => {
            e.preventDefault()
            var values = e.target.value
            getPeminjamanPerMonth(chartPeminjamanRuanganPerMonth, 'ruangan', values)
        })

        let select_grafik_alat = document.getElementById("select_grafik_alat")
        select_grafik_alat.addEventListener('change', (e) => {
            e.preventDefault()
            var values = e.target.value
            getPeminjamanPerMonth(chartPeminjamanAlatPerMonth, 'alat', values)
        })

        function getPeminjamanPerMonth(chart, type, year) {
            $.ajax({
                url: `${window.baseurl}/admin/api/peminjaman/${type}/${year}`,
                method: "GET",
                dataType: "json", //parse the response data as JSON automatically
                success: function(response) {
                    let total = []
                    let label_year = []
                    response.map(res => {
                        total.push(res.total)
                        label_year.push(res.month)
                    })
                    chart.updateOptions({
                        xaxis: {
                            categories: label_year,
                        },
                        subtitle: {
                            text: `Tahun ${year}`
                        },
                    })
                    chart.updateSeries([{
                        name: 'Total',
                        data: total
                    }])
                }
            });
        }
    </script>
@endpush
