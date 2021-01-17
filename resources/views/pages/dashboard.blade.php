@extends('layouts.app')

@section('title', 'Dashboard')
@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
</div>
@endsection

@section('content')
<div class="row mb-3">
  <!-- notifikasi untuk mahasiswa -->
  @if(Session::get('edited') == 'not yet')
  <div class="col-md-12">
    <div class="alert alert-danger" role="alert">
      Verifikasi tidak dapat dilakukan sebelum anda memperbarui profil anda.
      Pilih menu <a href="" class="text text-white" style="text-decoration: none;"><b>Perbarui Profil</b></a> untuk memperbarui profil anda.
    </div>
  </div>
  @endif
  <!-- penutup notifikasi -->

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Lulusan ({{ date('Y') }})</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="gradInYear">0</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              <span id="statusGrad">0%</span>
              <span>dari {{ date('Y')-1 }}</span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user-graduate fa-2x text-primary"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Selesai verifikasi ({{ date('Y') }})</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="hasVerif">0</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              <span id="statusVerif">0%</span>
              <span>dari seluruh wisudawan</span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user-check fa-2x text-success"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">RATA-RATA IPK ({{ date('Y') }})</div>
            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="ipk">0</div>
            <div class="mt-2 mb-0 text-muted text-xs">
              <span id="statusIpk">0%</span>
              <span>poin dari tahun {{ date('Y')-1 }}</span>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-chart-line fa-2x text-info"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-uppercase mb-1">Testimoni ({{ date('Y') }})</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" id="testi">0</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-comments fa-2x text-warning"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-6 col-lg-6 mb-4">
    <div class="card mb-4 h-100">
      <div class="card-header align-items-center justify-content-between" style="margin-top: 10px;">
        <div class="row">
          <div class="col-md-12">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Lulusan 5 Tahun Terakhir</h6>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <canvas id="chartGrad"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-6 col-lg-6 mb-4">
    <div class="card mb-4 h-100">
      <div class="card-header align-items-center justify-content-between" style="margin-top: 10px;">
        <div class="row">
          <div class="col-md-12">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Lulusan Per Prodi ({{ date('Y') }})</h6>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <canvas id="chartProdi"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="{{ Session::get('level') == 'admin' ? 'col-xl-7 col-lg-7' : 'col-xl-12 col-lg-12' }} mb-4">
    <div class="card mb-4 h-100">
      <div class="card-header align-items-center justify-content-between" style="margin-top: 10px;">
        <div class="row">
          <div class="col-md-12">
            <h6 class="m-0 font-weight-bold text-primary">Grafik Rata-Rata IPK 5 Tahun Terakhir</h6>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <canvas id="chartIpk"></canvas>
        </div>
      </div>
    </div>
  </div>
  @if(Session::get('level') == 'admin')
  <div class="col-xl-5 col-lg-5 mb-4">
    <div class="card mb-4 h-100">
      <div class="card-header align-items-center justify-content-between" style="margin-top: 10px;">
        <div class="row">
          <div class="col-lg-6">
            <h6 class="m-0 font-weight-bold text-primary">Peringkat IPK</h6>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <select id="searchByProdi" class="form-control form-control-sm select2" style="width: 100%;">
                <option value=""></option>
                @foreach($data as $data)
                <option value="{{ $data->id_prodi }}">{{ $data->nama_prodi }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body table-responsive" style="font-size: 12px;">
        <table class="table align-items-center table-flush table-hover" id="rank-table">
          <thead class="thead-light">
            <tr>
              <th width="10">No.</th>
              <th>NIM</th>
              <th>Wisudawan</th>
              <th>IPK</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="card-footer text-center">
        <a class="m-0 small text-primary card-link" href="{{ url('peringkat') }}">Selengkapnya <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </div>
  @endif

</div>
@endsection
@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ready(function() {
    $.ajax({
      url: "{{ route('api.counting') }}",
      type: "GET",
      success: function(result) {
        /*wisudawan*/
        $('#gradInYear').text(result.data.wisudawan.jumlah);
        $('#statusGrad').addClass('text-' + result.data.wisudawan.status);
        if (result.data.wisudawan.status == 'success') {
          $('#statusGrad').html('<i class="fas fa-arrow-up"></i> ' + result.data.wisudawan.rasio + '%');
        } else {
          $('#statusGrad').html('<i class="fas fa-arrow-down"></i> ' + result.data.wisudawan.rasio + '%');
        }

        /*verifikasi*/
        $('#hasVerif').text(result.data.verifikasi.jumlah);
        $('#statusVerif').addClass('text-' + result.data.verifikasi.status);
        $('#statusVerif').html(result.data.verifikasi.rasio + '%');

        /*IPK*/
        $('#ipk').text(result.data.ipk.ipk);
        $('#statusIpk').addClass('text-' + result.data.ipk.status);
        if (result.data.wisudawan.status == 'success') {
          $('#statusIpk').html('<i class="fas fa-arrow-up"></i> ' + result.data.ipk.rasio);
        } else {
          $('#statusIpk').html('<i class="fas fa-arrow-down"></i> ' + result.data.ipk.rasio);
        }

        /*Testimoni*/
        $('#testi').text(result.data.testi.jumlah);
      }
    });
    $(".select2").select2({
      theme: "classic",
      placeholder: "Pilih Prodi",
      allowClear: true
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
        "url": "{{ route('api.rank') }}",
        "data": function(data) {
          var id_prodi = $("#searchByProdi").val();

          data.searchByProdi = id_prodi;
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          name: 'nim'
        },
        {
          data: 'nim',
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
    $('#searchByProdi').change(function() {
      rank.draw();
    });
  });
</script>
<script>
  $(document).ready(function() {
    $.ajax({
      url: "{{ route('api.chartGrad') }}",
      method: "GET",
      success: function(data) {
        var label = [],
          value = [],
          data = data.data;

        for (var i in data) {
          label.push(data[i].tahun);
          value.push(data[i].jumlah);
        }
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Area Chart Example
        var ctx = document.getElementById("chartGrad");
        var myLineChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: label,
            datasets: [{
              label: "Lulusan",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 0.5)",
              borderColor: "rgba(78, 115, 223, 1)",
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
      url: "{{ route('api.chartIpk') }}",
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
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Area Chart Example
        var ctx = document.getElementById("chartIpk");
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: label,
            datasets: [{
              label: "IPK",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 0.5)",
              borderColor: "rgba(78, 115, 223, 1)",
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
      url: "{{ route('api.chartProdi') }}",
      method: "GET",
      success: function(data) {
        var label = [],
          value = [],
          prodi = data.prodi,
          grad = data.grad;

        for (var i in prodi) {
          label.push(prodi[i].nama_prodi);
        }
        for (var i in grad) {
          value.push(grad[i]);
        }

        var ict_unit = [],
          efficiency = [],
          coloR = [];

        var dynamicColors = function() {
          var r = Math.floor(Math.random() * 255);
          var g = Math.floor(Math.random() * 255);
          var b = Math.floor(Math.random() * 255);
          return "rgb(" + r + "," + g + "," + b + ")";
        };

        for (var i in prodi) {
          ict_unit.push("ICT Unit " + prodi[i].ict_unit);
          efficiency.push(prodi[i].efficiency);
          coloR.push(dynamicColors());
        }
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Pie Chart Example
        var ctx = document.getElementById("chartProdi");
        var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: label,
            datasets: [{
              data: value,
              backgroundColor: coloR,
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 20,
              yPadding: 20,
              displayColors: false,
              caretPadding: 5,
            },
            legend: {
              display: true,
              position: 'top'
            },
            cutoutPercentage: 80,
          },
        });
      }
    });
  });
</script>
@endpush