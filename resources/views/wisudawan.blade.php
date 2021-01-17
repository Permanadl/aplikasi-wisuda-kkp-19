@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/dataTables/DataTables-1.10.23/css/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-9">
            <div class="card bg-light">
                <div class="card-header bg-yellow">
                    Data Wisudawan
                </div>
                <div class="card-body mb-4">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" style="width: 100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama Lengkap</th>
                                    <th>Prodi</th>
                                    <th>Tahun</th>
                                    <th>Photo</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" id="grad">
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/plugins/dataTables/datatables.min.js') }}"></script>

<script>
    $(function(){
        $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [1, "asc"],
            pagingType: "full_numbers",
            ajax: "{{ route('front.wisudawan') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'nim'
                },
                {
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'link',
                    name: 'link'
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
                    data: 'img',
                    name: 'img'
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

        $.ajax({
            url: "{{ route('front.perprodi') }}",
            method: "GET",
            success: function(data) {
                var data = data.data;

                for (var i in data) {
                    $('#grad').append('<div class="col-sm-12 col-xs-3">'+
                        '<div class="card">'+
                            '<div class="card-header bg-yellow">'+ data[i].nama_prodi +'</div>'+
                            '<div class="card-body widget-body bg-light">'+
                                '<div class="row align-items-center mb-2 d-flex">'+
                                    '<div class="col-6">'+
                                        '<h2 class="d-flex align-items-center mb-0">'+ data[i].total +'</h2>'+
                                    '</div>'+
                                    '<div class="col-6 text-right text-success">'+
                                        '<span>'+ data[i].inyear +'</span>'+
                                    '</div>'+
                                    '<div class="col-6 d-flex text-muted"><span>Total</span></div>'+
                                    '<div class="col-6 text-muted text-right">'+
                                        '<span>Tahun {{ date('Y') }}</span>'+
                                    '</div>'+
                               ' </div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                    );
                }
            }
        });
    })
</script>
@endpush
