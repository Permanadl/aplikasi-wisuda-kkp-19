@extends('layouts.app')
@section('title', 'Administrator')
@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">
<style>
    .form-show hr {
        margin-top: -4px;
        border-top: 1px dotted grey;
    }

    .img-container {
        margin-bottom: 10px;
    }

    .img-profile {
        border-radius: 8px;
    }

    .identify {
        font-weight: bold;
    }

    .hr-text {
        line-height: 1em;
        position: relative;
        outline: 0;
        border: 0;
        color: #fc544b;
        text-align: center;
        height: 1.5em;
    }

    .hr-text::before {
        content: '';
        background: #fc544b;
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
    }

    .hr-text::after {
        content: attr(data-content);
        position: relative;
        display: inline-block;
        color: #fc544b;
        padding: 0 .5em;
        line-height: 1.5em;
        background-color: #ffffff;
    }
</style>
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Wisudawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Wisudawan</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        @if($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
        @elseif($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @endif
        <div class="card mb-4">
            <div class="card-header py-3 align-items-center justify-content-between">
                <a href="{{ route('wisudawan.create') }}" class="btn btn-primary modal-show" title="Tambah Data"><i class="fas fa-plus"></i> Tambah</a>
                <button class="btn btn-success" data-toggle="modal" data-target="#import"><i class="fas fa-upload"></i> Import Data</button>
            </div>
            <div class="table-responsive p-3" style="font-size: 14px;">
                <table class="table align-items-center table-flush table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th width="10">No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Prodi</th>
                            <th>Judul Skripsi</th>
                            <th>IPK</th>
                            <th width="110">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Prodi</th>
                            <th>Judul Skripsi</th>
                            <th>IPK</th>
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
<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Wisudawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('wisudawan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Pilih berkas</label>
                        <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1" required>
                    </div>
                    <p class="text text-danger">File harus berekstensi csv, xls atau xlsx.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);
</script>
<script>
    $(document).ready(function() {
        $('#choose-file').change(function() {
            var i = $(this).prev('label').clone();
            var file = $('#choose-file')[0].files[0].name;
            $(this).prev('label').text(file);
        });
        $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [1, "asc"],
            pagingType: "full_numbers",
            ajax: "{{ route('api.wisudawan') }}",
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
                    data: 'jk',
                    name: 'jk'
                },
                {
                    data: 'nama_prodi',
                    name: 'nama_prodi'
                },
                {
                    data: 'judul_skripsi',
                    name: 'judul_skripsi'
                },
                {
                    data: 'ipk',
                    name: 'ipk'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            columnDefs: [{
                "targets": [0, -1],
                "orderable": false,
                "searchable": false
            }],
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