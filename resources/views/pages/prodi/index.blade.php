@extends('layouts.app')
@section('title', 'Administrator')
@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Program Studi</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Program Studi</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{ route('prodi.create') }}" class="btn btn-primary modal-show" title="Tambah Data"><i class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="table-responsive p-3" style="font-size: 14px;">
                <table class="table align-items-center table-flush table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th width="10">No.</th>
                            <th>Kode Prodi</th>
                            <th>Nama Prodi</th>
                            <th>Jenjang</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Kode Prodi</th>
                            <th>Nama Prodi</th>
                            <th>Jenjang</th>
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
    $(document).ready(function () {
        $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [1, "asc"],
            pagingType: "full_numbers",
            ajax: "{{ route('api.prodi') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id_prodi'},
                {data: 'id_prodi', name: 'id_prodi'},
                {data: 'nama_prodi', name: 'nama_prodi'},
                {data: 'jenjang', name: 'jenjang'},
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