@extends('layout.base')
@section('title')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3 id="inventarisReady"></h3>
                            <p>Jumlah jenis barang</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-cube"></i>
                        </div>
                        <a href="{{ url('/cms/admin/inventaris') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i>
                            </a>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="inventarisCount"></h3>
                            <p>Total keseluruhan barang</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-cubes"></i>
                        </div>
                        <a href="{{ url('/cms/admin/inventaris') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i>
                            </a>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="borrowerCount"></h3>
                            <p>Jumlah Peminjam</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-users-between-lines"></i>
                        </div>
                        <a href="{{ url('/cms/admin/borrow') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="borrowCount"></h3>
                            <p>Total barang dipinjam</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-people-carry-box"></i>
                        </div>
                        <a href="{{ url('/cms/admin/borrow') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div>
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Selamat datang di aplikasi sistem inventaris Lab STMIK Adhi Guna <b>{{ auth()->user()->email }}</b> 🎉</h5>
                                    <p class="mb-4"></b></p>
                                    <i class="fa-sharp fa-solid fa-face-smile text-warning"></i>
                                    <a href="javascript:;" class="">Enjoy your work !!!</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img class="img-fluid mb-4" src="{{ asset('assets/img/package.svg') }}" alt="Responsive image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ini adalah script jQuery --}}
    <script>
        $(document).ready(function() {
            const dashboardService = new DashboardService();
            dashboardService.getCountInventaris();
        });

        class DashboardService {
            // Fetch Data
            async getCountInventaris() {
                try {
                    const response = await axios.get(`${appUrl}/v1/dashboard/count-inventaris`);
                    const responseData = response.data;

                    if (responseData) {
                        // Update mini card
                        $('#inventarisReady').html(responseData.getAllInvetaris); // Update jumlah jenis barang pada inventaris count
                        $('#inventarisCount').html(responseData.inventaris); // Update total keseluruhan barang pada inventaris count
                        $('#borrowerCount').html(responseData.borrower);        // Update total jenis peminjam count
                        $('#borrowCount').html(responseData.borrow);        // Update total barang dipinjam count
                    } else {
                        console.log('Data not found in the response');
                    }
                } catch (error) {
                    console.error('Error fetching inventory and borrow counts:', error);
                }
            }

           // Opsional
            async getDataLineCarth() {
                try {
                    const response = await axios.get(`${appUrl}/v1/dashboard/line-chart`);
                    const responseData = response.data;

                    if (responseData && responseData.status === 'success') {
                        const data = responseData.data;

                        if (data) {
                            const labels = ['Jumlah Jenis Barang', 'Total Barang', 'Jumlah Peminjam ', 'Barang Dipinjam'];
                            const counts = [data.totalInventarisIsReady, data.totalInventaris, data.borrowerTotal, data.totalBorrow];

                            this.chartJs(labels, counts);
                        } else {
                            $('#dataNotFound').removeAttr('hidden');
                        }
                    } else {
                        $('#dataNotFound').removeAttr('hidden');
                    }
                } catch (error) {
                    console.error('Error fetching line chart data:', error);
                    $('#dataNotFound').removeAttr('hidden');
                }
            }

            chartJs(labels, counts) {
                const ctx = $('#myChart')[0].getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah',
                            data: counts,
                            borderWidth: 4,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(255, 159, 64, 0.6)'
                            ],
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
        }
    </script>


@endsection
