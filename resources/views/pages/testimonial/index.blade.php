@extends('layouts.app')
@section('title', 'Testimonial')
@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">
<style>
    td.details-control {
        background: url('{{ asset("img/eye-solid.svg") }}') no-repeat center center;
        background-size: 20px 20px;
        cursor: pointer;
    }

    tr.details td.details-control {
        background: url('{{ asset("img/eye-slash-solid.svg") }}') no-repeat center center;
        background-size: 20px 20px;
    }
</style>
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Testimoni</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Testimoni</li>
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3" style="font-size: 14px;">
                <table class="table align-items-center table-flush table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th width="10"></th>
                            <th>Nama Wisudawan</th>
                            <th>Prodi</th>
                            <th>Tahun Lulusan</th>
                            <th>Rating</th>
                            <th width="50">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Nama Wisudawan</th>
                            <th>Prodi</th>
                            <th>Tahun Lulusan</th>
                            <th>Rating</th>
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
@endsection
@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
<script>
    function format(d) {
        return '<b>Testimoni :</b> ' + d.testimoni;
    }
    $(document).ready(function() {
        var dt = $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [1, "asc"],
            pagingType: "full_numbers",
            ajax: "{{ route('api.testimoni') }}",
            columns: [{
                    "class": "details-control",
                    "orderable": false,
                    "data": null,
                    "defaultContent": ""
                },
                {
                    "data": "nama_mhs",
                    "name": "nama_mhs"
                },
                {
                    "data": "nama_prodi",
                    "name": "nama_prodi"
                },
                {
                    "data": "tahun",
                    "name": "tahun"
                },
                {
                    "data": "rating",
                    "name": "rating"
                },
                {
                    "data": "action",
                    "name": "action"
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

        var detailRows = [];

        $('#table tbody').on('click', 'tr td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = dt.row(tr);
            var idx = $.inArray(tr.attr('id'), detailRows);

            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();

                detailRows.splice(idx, 1);
            } else {
                tr.addClass('details');
                row.child(format(row.data())).show();

                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
            }
        });

        dt.on('draw', function() {
            $.each(detailRows, function(i, id) {
                $('#' + id + ' td.details-control').trigger('click');
            });
        });
    });
</script>
@endpush