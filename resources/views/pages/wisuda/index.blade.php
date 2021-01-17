@extends('layouts.app')
@section('title', 'Wisuda')
@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Wisuda</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Wisuda</li>
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{ route('wisuda.create') }}" class="btn btn-primary modal-show" title="Tambah Data"><i class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="table-responsive p-3" style="font-size: 14px;">
                <table class="table align-items-center table-flush table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th width="10">No.</th>
                            <th>Tahun</th>
                            <th>Angkatan Ke-</th>
                            <th>Tanggal Wisuda</th>
                            <th>Tanggal Yudisium</th>
                            <th>Tempat</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Tahun</th>
                            <th>Angkatan Ke-</th>
                            <th>Tanggal Wisuda</th>
                            <th>Tanggal Yudisium</th>
                            <th>Tempat</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('layouts._modal')
@endsection
@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $.fn.dataTable.render.tgl = function(data){
        return function(data){
            var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
            var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            var tanggal = new Date(data).getDate();
            var _hari = new Date(data).getDay();
            var _bulan = new Date(data).getMonth();
            var _tahun = new Date(data).getYear();

            var hari = hari[_hari];
            var bulan = bulan[_bulan];

            var tahun = (_tahun < 1000) ? _tahun + 1900 : _tahun;

            var hasil = hari + ', '+ tanggal +' '+ bulan +' '+ tahun;
            return hasil;
        }
    }

    $(document).ready(function () {
        $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [1, "asc"],
            pagingType: "full_numbers",
            ajax: "{{ route('api.graduation') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'tahun'},
                {data: 'tahun', name: 'tahun'},
                {data: 'angkatan', name: 'angkatan'},
                {data: 'tgl_wisuda', name: 'tgl_wisuda', render: $.fn.dataTable.render.tgl()},
                {data: 'tgl_yudisium', name: 'tgl_yudisium', render: $.fn.dataTable.render.tgl()},
                {data: 'tempat', name: 'tempat'},
                {data: 'action', name: 'action'}
            ],
            columnDefs: [
                {
                    "targets": [0, -1],
                    "orderable": false,
                    "searchable": false
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
                "search": "Pencarian",
                "paginate": {
                    "first": "<<",
                    "last": ">>",
                    "next": ">",
                    "previous": "<"
                }
            }
        });
    });
</script>
@endpush