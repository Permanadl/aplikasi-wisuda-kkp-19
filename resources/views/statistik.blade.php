@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/dataTables/DataTables-1.10.23/css/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="row mt-3">
    </div>
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header bg-blue">
                    Statistik Prodi
                </div>
                <div class="card-body mb-4">
                    <canvas id="Prodi" height="188px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-header bg-blue">
                            Statistik Jenis Kelamin
                        </div>
                        <div class="card-body mb-4">
                            <canvas id="Jk"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-header bg-blue">
                            Statistik Rata-rata IPK
                        </div>
                        <div class="card-body mb-4">
                            <canvas id="Ipk"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/chartjs/dist/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dataTables/datatables.min.js') }}"></script>
<script>
    var Jk = document.getElementById('Jk');
    var JkChart = new Chart(Jk, {
        type: 'pie',
        data: {
            labels: ['L', 'P'],
            datasets: [{
                data: [<?= $data['l'] ?>, <?= $data['p'] ?>],
                backgroundColor: [
                    'rgba(189, 99, 132, 0.2)',
                    'rgba(94, 126, 189, 0.2)'
                ],
                borderColor: [
                    'rgba(189, 99, 132, 1)',
                    'rgba(94, 126, 189, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom'
            }
        }
    });
</script>
<script>
    $(function() {
        $.ajax({
            url: "{{ route('front.prodi') }}",
            method: "GET",
            success: function(data) {
                var label = [],
                    value = [],
                    datasets = [],
                    dataObj = data.data;

                for (var i in dataObj) {
                    label.push(dataObj[i].tahun);
                }

                let obj = {};
                for (var i in dataObj) {
                    value.push(dataObj[i].data[2].jumlah);
                }

                obj = {
                    label: 'Manajemen Informatika',
                    data: value,
                    backgroundColor: 'rgba(189, 99, 132, 0.2)',
                    borderColor: 'rgba(189, 99, 132, 1)',
                    borderWidth: 1
                };
                datasets.push(obj);
                value = [];

                for (var i in dataObj) {
                    value.push(dataObj[i].data[0].jumlah);
                }

                obj = {
                    label: 'Teknik Informatika',
                    data: value,
                    backgroundColor: 'rgba(94, 126, 189, 0.2)',
                    borderColor: 'rgba(94, 126, 189, 1)',
                    borderWidth: 1
                };
                datasets.push(obj);
                value = [];

                for (var i in dataObj) {
                    value.push(dataObj[i].data[1].jumlah);
                }

                obj = {
                    label: 'Sistem Informasi',
                    data: value,
                    backgroundColor: 'rgba(72, 189, 122, 0.2)',
                    borderColor: 'rgba(72, 189, 122, 1)',
                    borderWidth: 1
                };
                datasets.push(obj);

                console.log(datasets);

                // Area Chart Example
                var Prodi = document.getElementById('Prodi');
                var ProdiChart = new Chart(Prodi, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: datasets
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
        $.ajax({
            url: "{{ route('front.ipk') }}",
            method: "GET",
            success: function(data) {
                var label = [],
                    value = [],
                    data = data.data;

                for (var i in data) {
                    label.push(data[i].tahun);
                    value.push(data[i].ipk);
                }

                // Set new default font family and font color to mimic Bootstrap's default styling
                /* Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796'; */

                // Area Chart Example
                var ctx = document.getElementById("Ipk");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: label,
                        datasets: [{
                            label: "IPK",
                            lineTension: 0.3,
                            backgroundColor: 'rgba(189, 99, 132, 0.2)',
                            borderColor: 'rgba(189, 99, 132, 1)',
                            pointRadius: 3,
                            pointBackgroundColor: 'rgba(189, 99, 132, 1)',
                            pointBorderColor: 'rgba(189, 99, 132, 1)',
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(27, 48, 88, 1)",
                            pointHoverBorderColor: "rgba(27, 48, 88, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: value,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10
                        }
                    }
                });
            }
        });
    })
</script>
@endpush