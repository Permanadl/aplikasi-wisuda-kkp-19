@extends('layouts.app')
@section('title', 'Administrator')
@push('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Administrator</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Data</li>
        <li class="breadcrumb-item active" aria-current="page">Administrator</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="{{ route('admin.create') }}" class="btn btn-primary modal-show" title="Tambah Data"><i class="fas fa-plus"></i> Tambah</a>
            </div>
            <div class="table-responsive p-3" style="font-size: 14px;">
                <table class="table align-items-center table-flush table-hover" id="table">
                    <thead class="thead-light">
                        <tr>
                            <th width="10">No.</th>
                            <th>Nama Administrator</th>
                            <th>Nama Pengguna</th>
                            <th>Terakhir Login</th>
                            <th width="110">Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Nama Administrator</th>
                            <th>Nama Pengguna</th>
                            <th>Terakhir Login</th>
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
<div class="modal fade" id="reset" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modal-header">
                <h4 class="modal-title" id="reset-title">Form Input</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body" id="reset-form" style="overflow: hidden;">
            </div>

            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="modal-btn-reset">Reset</button>
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
    $(document).ready(function() {
        $('body').on('click', '.modal-reset', function(event) {
            event.preventDefault();

            var me = $(this),
                url = me.attr('href'),
                title = me.attr('title');

            $('#reset-title').text(title);
            $.ajax({
                url: url,
                dataType: 'html',
                success: function(response) {
                    $('#reset-form').html(response);
                }
            });

            $('#reset').modal('show');
        });
        $('#modal-btn-reset').click(function(event) {
            event.preventDefault;

            var form = $('#reset-form form'),
                url = form.attr('action'),
                method = 'PUT';

            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');
            $.ajax({
                url: url,
                method: method,
                data: form.serialize(),
                success: function(response) {
                    form.trigger('reset');
                    $('#reset').modal('hide');
                    $('#table').DataTable().ajax.reload();

                    Swal.fire({
                        title: 'Sukses !',
                        icon: 'success',
                        text: 'Akun berhasil di reset!'
                    });
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;

                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(key, value) {
                            $('#' + key)
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .append('<div class="invalid-feedback">' + value + '</div>')
                        });
                    }
                }
            })
        });
    });
</script>
<script>
    $.fn.dataTable.render.last_login = function(data) {
        return function(data) {
            if (data === null) {
                return 'Belum ada aktivitas login';
            }
            return data;
        }
    }

    $(document).ready(function() {
        $('#table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [1, "asc"],
            pagingType: "full_numbers",
            ajax: "{{ route('api.admin') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'nama_admin',
                    name: 'nama_admin'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'last_login',
                    name: 'last_login',
                    render: $.fn.dataTable.render.last_login()
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