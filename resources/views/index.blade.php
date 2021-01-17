@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/chartjs/dist/Chart.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/plugins/dataTables/DataTables-1.10.23/css/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-sm-4 col-xs-3">
            <div class="card">
                <div class="card-header bg-yellow">
                    Lulusan
                </div>
                <div class="card-body widget-body bg-light">
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-6">
                            <h2 class="d-flex align-items-center mb-0" id="gradTotal">
                                0
                            </h2>
                        </div>
                        <div class="col-6 text-right text-success">
                            <span id="gradInYear">0</span>
                            <i class="fa fa-arrow-up"></i>
                        </div>
                        <div class="col-6 d-flex text-muted">
                            <span>Total</span>
                        </div>
                        <div class="col-6 text-muted text-right">
                            <span>Tahun {{ date('Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-3">
            <div class="card">
                <div class="card-header bg-yellow">
                    IPK
                </div>
                <div class="card-body widget-body bg-light">
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-6">
                            <h2 class="d-flex align-items-center mb-0" id="ipk">
                                0.00
                            </h2>
                        </div>
                        <div class="col-6 text-right">
                            <span id="statusIpk">0.00 <i class="fa fa-arrow-up"></i></span>
                        </div>
                        <div class="col-6 d-flex text-muted">
                            <span>AVG Total</span>
                        </div>
                        <div class="col-6 text-muted text-right">
                            <span>Margin dari {{ date('Y')-1 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-xs-3">
            <div class="card">
                <div class="card-header bg-yellow">
                    Cum Laude
                </div>
                <div class="card-body widget-body bg-light">
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0" id="cumTotal">
                                0
                            </h2>
                        </div>
                        <div class="col-4 text-right text-success">
                            <span id="cumInYear">0 </span> <i class="fa fa-arrow-up"></i>
                        </div>
                        <div class="col-6 d-flex text-muted">
                            <span>Total Lulusan</span>
                        </div>
                        <div class="col-6 text-muted text-right">
                            <span>Tahun {{ date('Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header bg-blue">
                    Grafik Lulusan
                </div>
                <div class="card-body mb-4">
                    <canvas id="chartGrad"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header bg-blue">
                    IPK Tertinggi
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-2">
                            <select name="tahun" class="form-control form-control-sm select-tahun" id="searchByYear">
                                <option></option>
                                @foreach ($tahun as $row)
                                <option value="{{ $row->tahun }}">{{ $row->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <div class="filter">
                                <select name="prodi" class="form-control form-control-sm select-prodi"
                                    id="searchByProdi">
                                    <option></option>
                                    @foreach ($prodi as $row)
                                    <option value="{{ $row->nama_prodi }}">{{ $row->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm" id="rank-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Wisudawan</th>
                                            <th>IPK</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-5">
        <div class="col-md-12">
            <div class="customer-feedback">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="section-title">Testimoni Wisudawan</h2>
                        </div><!-- /End col -->
                    </div><!-- /End row -->

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="owl-carousel feedback-slider">
                                <!-- slider item -->
                                @foreach ($testi as $item)
                                <div class="feedback-slider-item">
                                    <img src="{{ $item->photo == NULL ? asset('photo/students/default.jpg') : asset('photo/students/'.$item->photo)}}"
                                        class="center-block img-top img-circle" alt="Feedback">
                                    <h3 class="customer-name">{{ $item->nama_mhs }}</h3>
                                    <p>{{ $item->testimoni }}</p>
                                    <span class="light-bg customer-rating" data-rating="5">
                                        {{ $item->rating }}
                                        <i class="fa fa-star"></i>
                                    </span>
                                </div>
                                @endforeach
                                <!-- /slider item -->

                            </div><!-- /End feedback-slider -->
                            <!-- side thumbnail -->
                            <div class="feedback-slider-thumb hidden-xs">
                                @foreach ($testi as $key => $item)
                                @if ($key == $thumb['left'])
                                <div class="thumb-prev">
                                    <span>
                                        <img src="{{ $item->photo == NULL ? asset('photo/students/default.jpg') : asset('photo/students/'.$item->photo) }}"
                                            alt="Customer Feedback">
                                    </span>
                                    <span class="light-bg customer-rating">
                                        {{ $item->rating }}
                                        <i class="fa fa-star"></i>
                                    </span>
                                </div>
                                @endif
                                @endforeach

                                @foreach ($testi as $key => $item)
                                @if ($key == $thumb['right'])
                                <div class="thumb-next">
                                    <span>
                                        <img src="{{ $item->photo == NULL ? asset('photo/students/default.jpg') : asset('photo/students/'.$item->photo) }}"
                                            alt="Customer Feedback">
                                    </span>
                                    <span class="light-bg customer-rating">
                                        {{ $item->rating }}
                                        <i class="fa fa-star"></i>
                                    </span>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <!-- /side thumbnail -->

                        </div><!-- /End col -->
                    </div><!-- /End row -->
                </div><!-- /End container -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/OwlCarousel2-2.3.4/src/js/owl.carousel.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/chartjs/dist/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dataTables/datatables.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
<script>
    $(document).ready(function () {
        $('.select-tahun').select2({
            placeholder: 'Pilih Tahun Lulusan'
        });
        $('.select-prodi').select2({
            placeholder: 'Pilih Prodi'
        });
        var feedbackSlider = $('.feedback-slider');
        feedbackSlider.owlCarousel({
            items: 1,
            nav: true,
            dots: true,
            autoplay: true,
            loop: true,
            mouseDrag: true,
            touchDrag: true,
            navText: ["<i class='fa fa-arrow-left'></i>",
                "<i class='fa fa-arrow-right'></i>"
            ],
            responsive: {

                // breakpoint from 767 up
                767: {
                    nav: true,
                    dots: false
                }
            }
        });

        feedbackSlider.on("translate.owl.carousel", function () {
            $(".feedback-slider-item h3").removeClass("animated fadeIn").css("opacity", "0");
            $(".feedback-slider-item img, .feedback-slider-thumb img, .customer-rating")
                .removeClass("animated zoomIn").css("opacity", "0");
        });

        feedbackSlider.on("translated.owl.carousel", function () {
            $(".feedback-slider-item h3").addClass("animated fadeIn").css("opacity", "1");
            $(".feedback-slider-item img, .feedback-slider-thumb img, .customer-rating")
                .addClass("animated zoomIn").css("opacity", "1");
        });
        feedbackSlider.on('changed.owl.carousel', function (property) {
            var current = property.item.index;
            var prevThumb = $(property.target).find(".owl-item").eq(current).prev().find("img")
                .attr('src');
            var nextThumb = $(property.target).find(".owl-item").eq(current).next().find("img")
                .attr('src');
            var prevRating = $(property.target).find(".owl-item").eq(current).prev().find(
                'span').attr('data-rating');
            var nextRating = $(property.target).find(".owl-item").eq(current).next().find(
                'span').attr('data-rating');
            $('.thumb-prev').find('img').attr('src', prevThumb);
            $('.thumb-next').find('img').attr('src', nextThumb);
            $('.thumb-prev').find('span').next().html(prevRating +
                '<i class="fa fa-star"></i>');
            $('.thumb-next').find('span').next().html(nextRating +
                '<i class="fa fa-star"></i>');
        });
        $('.thumb-next').on('click', function () {
            feedbackSlider.trigger('next.owl.carousel', [300]);
            return false;
        });
        $('.thumb-prev').on('click', function () {
            feedbackSlider.trigger('prev.owl.carousel', [300]);
            return false;
        });

        var rank = $('#rank-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            serverMethod: 'post',
            searching: false,
            ordering: false,
            paging: false,
            info: false,
            scrollY: "200px",
            scrollCollapse: true,
            ajax: {
                "url": "{{ route('front.rank') }}",
                "data": function (data) {
                    var prodi = $("#searchByProdi").val();
                    var tahun = $("#searchByYear").val();

                    data.searchByProdi = prodi;
                    data.searchByYear = tahun;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'nim'
                },
                {
                    data: 'nama_mhs',
                    name: 'nama_mhs'
                },
                {
                    data: 'ipk',
                    name: 'ipk'
                }
            ],
            language: {
                "zeroRecords": "Ups !! Tidak ada data apapun",
                "processing": "Memuat...",
                "loadingRecords": "Memuat..."
            }
        });
        $('#searchByProdi').change(function () {
            rank.draw();
        });
        $('#searchByYear').change(function () {
            rank.draw();
        });

        $.ajax({
            url: "{{ route('front.grad') }}",
            method: "GET",
            success: function (data) {
                var label = [],
                    value = [],
                    data = data.data;

                for (var i in data) {
                    label.push(data[i].tahun);
                    value.push(data[i].jumlah);
                }
                // Set new default font family and font color to mimic Bootstrap's default styling
                /*  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                 Chart.defaults.global.defaultFontColor = '#858796'; */

                // Area Chart Example
                var ctx = document.getElementById("chartGrad");
                var myLineChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: label,
                        datasets: [{
                            label: "Lulusan",
                            lineTension: 0.3,
                            backgroundColor: 'rgba(242, 190, 30, 0.5)',
                            borderColor: 'rgba(242, 190, 30, 1)',
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
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

        $.ajax({
            url: "{{ route('front.counting') }}",
            type: "GET",
            success: function (result) {
                /*lulusan*/
                $('#gradTotal').text(result.data.lulusan.total);
                $('#gradInYear').text(result.data.lulusan.inyear);

                /*IPK*/
                $('#ipk').text(result.data.ipk.ipk);
                $('#statusIpk').addClass('text-' + result.data.ipk.status);
                if (result.data.ipk.status == 'success') {
                    $('#statusIpk').html(result.data.ipk.margin +
                        ' <i class="fas fa-arrow-up"></i>');
                } else if (result.data.ipk.status == 'danger') {
                    $('#statusIpk').html(result.data.ipk.margin +
                        ' <i class="fas fa-arrow-down"></i>');
                } else {
                    $('#statusIpk').html(result.data.ipk.margin + ' <i class="fas fa-minus"></i>');
                }

                /*Cum Laude*/
                $('#cumTotal').text(result.data.cumlaude.total);
                $('#cumInYear').text(result.data.cumlaude.total);
            }
        });


    }); //end ready

</script>
@endpush
