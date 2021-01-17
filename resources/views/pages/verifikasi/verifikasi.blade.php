@extends('layouts.app')
@section('title', 'Detail Verifikasi')
@push('css')
<link href="{{ asset('vendor/sweetalert/sweetalert.css') }}" rel="stylesheet">
<style>
    .title {
        margin-top: 10px;
    }

    .title span {
        font-weight: bold;
    }

    .img-container {
        padding-left: 15px;
        padding-bottom: 15px;
        padding-right: 15px;
        padding-top: 10px;
    }

    .has-hover {
        width: auto;
        height: 300px;
        max-height: 300px;
        cursor: pointer;
    }

    .no-hover {
        width: auto;
        height: 300px;
        max-height: 300px;
    }

    .has-hover:hover {
        opacity: 0.5;
    }

    .action {
        padding-left: 15px;
        padding-bottom: 15px;
        padding-right: 15px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 999999;
        padding-top: 10px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

    .status {
        margin-top: 10px;
    }
</style>
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Verifikasi</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('verifikasi') }}">Verifikasi</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $data->nama_mhs }}</li>
    </ol>
</div>
@endsection
@section('content')
<div class=" message">
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="text text-center title">
                        <span class="text text-primary">Bukti Pembayaran</span>
                    </div>
                    <div class="img-container" align="center">
                        @if($data->status_pembayaran == 'approved')
                        <img class="img-thumbnail no-hover" src="{{ asset('photo/verifications/pembayaran/'.$data->pembayaran)  }}">
                        <div class="status text text-success">
                            <span class="fa fa-check-circle"></span> Terverifikasi
                        </div>
                        @elseif($data->status_pembayaran == 'rejected')
                        <img class="img-thumbnail no-hover" src="{{ asset('photo/verifications/pembayaran/'.$data->pembayaran)  }}">
                        <div class="status text text-danger">
                            <span class="fa fa-times-circle"></span> Ditolak
                        </div>
                        @else
                        <img id="imgPembayaran" class="img-thumbnail has-hover" src="{{ $data->pembayaran == NULL ? asset('photo/verifications/pembayaran/default.jpg') : asset('photo/verifications/pembayaran/'.$data->pembayaran)  }}">
                        <div id="modalPembayaran" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="pembayaran">
                        </div>
                        @endif
                    </div>
                    @if($data->status_pembayaran == 'pending')
                    <div class="action">
                        <button data-title="pembayaran" data-type="verifikasi" title="Verifikasi Bukti Pembayaran" class="btn btn-success btn-block swal-show">Verifikasi</button>
                        <button data-title="pembayaran" data-type="reject" title="Tolak Verifikasi Bukti Pembayaran" class="btn btn-danger btn-block swal-show">Tolak</button>
                    </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="text text-center title">
                        <span class="text text-primary">Bukti LPPM</span>
                    </div>
                    <div class="img-container" align="center">
                        @if($data->status_lppm == 'approved')
                        <img class="img-thumbnail no-hover" src="{{ asset('photo/verifications/lppm/'.$data->lppm)  }}">
                        <div class="status text text-success">
                            <span class="fa fa-check-circle"></span>Terverifikasi
                        </div>
                        @elseif($data->status_lppm == 'rejected')
                        <img class="img-thumbnail no-hover" src="{{ asset('photo/verifications/lppm/'.$data->lppm)  }}">
                        <div class="status text text-danger">
                            <span class="fa fa-times-circle"></span> Ditolak
                        </div>
                        @else
                        <img id="imgLppm" class="img-thumbnail has-hover" src="{{ $data->lppm == NULL ? asset('photo/verifications/lppm/default.jpg') : asset('photo/verifications/lppm/'.$data->lppm)  }}">
                        <div id="modalLppm" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="lppm">
                        </div>
                        @endif
                    </div>
                    @if($data->status_lppm == 'pending')
                    <div class="action">
                        <button data-title="lppm" data-type="verifikasi" title="Verifikasi Bukti LPPM" class="btn btn-success btn-block swal-show">Verifikasi</button>
                        <button data-title="lppm" data-type="reject" title="Tolak Verifikasi Bukti LPPM" class="btn btn-danger btn-block swal-show">Tolak</button>
                    </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="text text-center title">
                        <span class="text text-primary">Bukti Perpustakaan</span>
                    </div>
                    <div class="img-container" align="center">
                        @if($data->status_perpus== 'approved')
                        <img class="img-thumbnail no-hover" src="{{ asset('photo/verifications/perpustakaan/'.$data->perpus) }}">
                        <div class="status text text-success">
                            <span class="fa fa-check-circle"></span>Terverifikasi
                        </div>
                        @elseif($data->status_perpus == 'rejected')
                        <img class="img-thumbnail no-hover" src="{{ asset('photo/verifications/perpustakaan/'.$data->perpus)  }}">
                        <div class="status text text-danger">
                            <span class="fa fa-times-circle"></span> Ditolak
                        </div>
                        @else
                        <img id="imgPerpus" class="img-thumbnail has-hover" src="{{ $data->perpus == NULL ? asset('photo/verifications/perpustakaan/default.jpg') : asset('photo/verifications/perpustakaan/'.$data->perpus)  }}">
                        <div id="modalPerpus" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="perpus">
                        </div>
                        @endif
                    </div>
                    @if($data->status_perpus == 'pending')
                    <div class="action">
                        <button data-title="perpus" data-type="verifikasi" title="Verifikasi Bukti Perpustakaan" class="btn btn-success btn-block swal-show">Verifikasi</button>
                        <button data-title="perpus" data-type="reject" title="Tolak Verifikasi Bukti Perpustakaan" class="btn btn-danger btn-block swal-show">Tolak</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        window.setTimeout(function() {
            $("#div-alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
        $('#imgPembayaran').click(function() {
            $('#modalPembayaran').css('display', 'block');
            var src = $(this).attr('src');
            $('#pembayaran').attr('src', src);
        });

        $('#imgLppm').click(function() {
            $('#modalLppm').css('display', 'block');
            var src = $(this).attr('src');
            $('#lppm').attr('src', src);
        });

        $('#imgPerpus').click(function() {
            $('#modalPerpus').css('display', 'block');
            var src = $(this).attr('src');
            $('#perpus').attr('src', src);
        });

        $('.close').click(function() {
            $('.modal').css('display', 'none');
        });

        $('.swal-show').click(function(e) {
            e.preventDefault();

            var field = $(this).attr('data-title'),
                type = $(this).attr('data-type'),
                title = $(this).attr('title');

            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: $(this).hasClass('btn-success') ? '#3085d6' : '#d33',
                cancelButtonColor: $(this).hasClass('btn-success') ? '#d33' : '#3085d6',
                cancelButtonText: 'Batalkan',
                confirmButtonText: $(this).hasClass('btn-success') ? 'Ya, Verifikasi' : 'Ya, Tolak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('verif', $data->nim) }}",
                        type: "POST",
                        data: {
                            'field': field,
                            'type': type
                        },
                        success: function(response) {
                            $(".message").html('<div class="row" id="div-alert">' +
                                '<div class="col-lg-12">' +
                                '<div class="mb-4">' +
                                '<div id="alert" class="alert alert-success">' + response.message + '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                            window.setTimeout(function() {
                                location.reload();
                            }, 4500)
                            console.log(response);
                        },
                        error: function(xhr) {
                            $(".message").html('<div class="row" id="div-alert">' +
                                '<div class="col-lg-12">' +
                                '<div class="mb-4">' +
                                '<div id="alert" class="alert alert-danger">' + xhr.message + '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                            console.log(xhr);
                        }
                    });
                }
            });
        });
    });
</script>
@endpush