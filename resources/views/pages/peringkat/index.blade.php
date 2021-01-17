@extends('layouts.app')
@section('title', 'Peringkat')
@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet" />
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Peringkat Wisudawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Peringkat</li>
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header align-items-center justify-content-between">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-form-label">
                                Seleksi berdasarkan prodi
                                <select id="searchByProdi" class="form-control form-control-sm select2" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($data as $data)
                                    <option value="{{ $data->nama_prodi }}">{{ $data->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-form-label">
                                Seleksi berdasarkan tahun lulusan
                                <input type="text" class="form-control form-control-sm" id="searchByYear">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive p-3" style="font-size: 14px; margin-top: -15px;">
                <table class="table align-items-center table-flush table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th width="10">No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Tahun</th>
                            <th>IPK</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Tahun</th>
                            <th>IPK</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script>
    $(function() {
        $('#searchByYear').datepicker({
            viewMode: 'years',
            minViewMode: 'years',
            format: 'yyyy',
            autoclose: true,
            orientation: "bottom auto",
        });
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $(".select2").select2({
            theme: "classic",
            placeholder: "Pilih Prodi",
            allowClear: true
        });
        var dataTable = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            serverMethod: 'post',
            searching: false,
            ordering: false,
            pagingType: "full_numbers",
            ajax: {
                "url": "{{ route('api.peringkat') }}",
                "data": function(data) {
                    var nama_prodi = $("#searchByProdi").val();
                    var tahun = $("#searchByYear").val();

                    data.searchByProdi = nama_prodi;
                    data.searchByYear = tahun;
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
                    data: 'nama_prodi',
                    name: 'nama_prodi'
                },
                {
                    data: 'tahun',
                    name: 'tahun'
                },
                {
                    data: 'ipk',
                    name: 'ipk'
                }
            ],
            language: {
                "lengthMenu": "Menampilkan _MENU_ data",
                "zeroRecords": "Ups !! Tidak ada data apapun",
                "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                "infoEmpty": "Tidak ada data yang dapat ditampilkan",
                "infoFiltered": "(Disortir dari _MAX_ data)",
                "processing": "Memuat...",
                "loadingRecords": "Memuat...",
                "paginate": {
                    "first": "<<",
                    "last": ">>",
                    "next": ">",
                    "previous": "<"
                }
            }
        });

        $('#searchByProdi').change(function() {
            dataTable.draw();
        });

        $('#searchByYear').change(function() {
            dataTable.draw();
        });
    });
</script>
@endpush