@extends('layouts.app')
@section('title', 'Verifikasi')
@push('css')
<style>
    .image-container {
        background-color: #ffffff;
        margin-bottom: 5px;
    }

    .image-preview {
        display: block;
        width: 50%;
    }
</style>
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Verifikasi</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Verifikasi</li>
    </ol>
</div>
@endsection
@section('content')
@if (Session::has('success'))
<div class="row" id="div-alert">
    <div class="col-lg-12">
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6 class="mb-2 font-weight-bold text-primary">Bukti Pembayaran</h6>
                        @if ($data->pembayaran == NULL OR $data->status_pembayaran == 'not uploaded')
                        <form action="{{ Route('pembayaran') }}" id="form-1" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="image-container" align="center">
                                    <img src="" alt="" id="preview-pembayaran" class="image-preview">
                                </div>
                                <input name="file" accept="image/*" class="form-control" type="file" id="pembayaran" onchange="previewPembayaran();" />
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-primary" type="submit">Unggah Bukti Pembayaran</button>
                            </div>
                        </form>
                        @else
                        @if ($data->status_pembayaran == 'approved')
                        <div class="alert alert-success" role="alert">
                            Bukti pembayaran telah disetujui.
                        @elseif($data->status_pembayaran == 'rejected')
                        <div class="alert alert-danger" role="alert">
                           Bukti pembayaran tidak disetujui, silahkan unggah kembali bukti pembayaran yang benar.
                        @elseif($data->status_pembayaran == 'pending')
                        <div class="alert alert-warning" role="alert">
                            Menunggu verifikasi.
                        @endif
                            <p>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#detailPembayaran">Lihat Gambar</a>
                            </p>
                        </div>
                        <div class="modal fade" id="detailPembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Bukti Pembayaran</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('pembayaran') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="image-container" align="center">
                                                <img src="{{ asset('photo/verifications/pembayaran/'.$data->pembayaran) }}" id="preview-pembayaran" class="image-preview">
                                            </div>
                                            @if ($data->status_pembayaran == 'pending' OR $data->status_pembayaran == 'rejected')
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Pilih berkas</label>
                                                <input type="file" accept="image/*" name="file" id="pembayaran" class="form-control-file" onchange="previewPembayaran();" required>
                                            </div>
                                            <p class="text text-danger">Unggah ulang untuk mengganti bukti pembayaran.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                            @if ($data->status_pembayaran == 'pending' OR $data->status_pembayaran == 'rejected')
                                            <button type="submit" class="btn btn-primary">Unggah</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6 class="mb-2 font-weight-bold text-primary">Bukti LPPM</h6>
                        @if ($data->lppm == NULL)
                        <form action="{{ route('lppm') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="image-container" align="center">
                                    <img src="" alt="" id="preview-lppm" class="image-preview">
                                </div>
                                <input name="file" class="form-control" accept="image/*" type="file" id="lppm" onchange="previewLppm();" />
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-primary" type="submit">Unggah Bukti LPPM</button>
                            </div>
                        </form>
                        @else
                        @if ($data->status_lppm == 'approved')
                        <div class="alert alert-success" role="alert">
                            Bukti pembayaran telah disetujui.
                        @elseif($data->status_lppm == 'rejected')
                        <div class="alert alert-danger" role="alert">
                           Bukti pembayaran tidak disetujui, silahkan unggah kembali bukti pembayaran yang benar.
                        @elseif($data->status_lppm == 'pending')
                        <div class="alert alert-warning" role="alert">
                            Menunggu verifikasi.
                        @endif
                            <p>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#detailLppm">Lihat Gambar</a>
                            </p>
                        </div>
                        <div class="modal fade" id="detailLppm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Bukti LPPM</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('lppm') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="image-container" align="center">
                                                <img src="{{ asset('photo/verifications/lppm/'.$data->lppm) }}" id="preview-lppm" class="image-preview">
                                            </div>
                                            @if ($data->status_lppm == 'pending' OR $data->status_lppm == 'rejected')
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Pilih berkas</label>
                                                <input type="file" accept="image/*" name="file" id="lppm" class="form-control-file" onchange="previewLppm();" required>
                                            </div>
                                            <p class="text text-danger">Unggah ulang untuk mengganti bukti LPPM.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                            @if ($data->status_lppm == 'pending' OR $data->status_lppm == 'rejected')
                                            <button type="submit" class="btn btn-primary">Unggah</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6 class="mb-2 font-weight-bold text-primary">Bukti Perpustakaan</h6>
                        @if ($data->perpus == NULL)
                        <form action="{{ route('perpus') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="image-container" align="center">
                                    <img src="" alt="" id="preview-perpus" class="image-preview">
                                </div>
                                <input name="file" class="form-control" accept="image/*" type="file" id="perpus" onchange="previewPerpus();" />
                            </div>
                            <div class="form-group">
                                <button class="btn btn-block btn-primary">Unggah Bukti Perpustakaan</button>
                            </div>
                        </form>
                        @else
                        @if ($data->status_perpus == 'approved')
                        <div class="alert alert-success" role="alert">
                            Bukti pembayaran telah disetujui.
                        @elseif($data->status_perpus == 'rejected')
                        <div class="alert alert-danger" role="alert">
                           Bukti pembayaran tidak disetujui, silahkan unggah kembali bukti pembayaran yang benar.
                        @elseif($data->status_perpus == 'pending')
                        <div class="alert alert-warning" role="alert">
                            Menunggu verifikasi.
                        @endif
                            <p>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#detailPerpus">Lihat Gambar</a>
                            </p>
                        </div>
                        <div class="modal fade" id="detailPerpus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Bukti Perpustakaan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('perpus') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="image-container" align="center">
                                                <img src="{{ asset('photo/verifications/perpustakaan/'.$data->perpus) }}" id="preview-perpus" class="image-preview">
                                            </div>
                                            @if ($data->status_perpus == 'pending' OR $data->status_perpus == 'rejected')
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Pilih berkas</label>
                                                <input type="file" accept="image/*" name="file" id="perpus" class="form-control-file" onchange="previewPerpus();" required>
                                            </div>
                                            <p class="text text-danger">Unggah ulang untuk mengganti bukti perpustakaan.</p>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                            @if ($data->status_perpus == 'pending' OR $data->status_perpus == 'rejected')
                                            <button type="submit" class="btn btn-primary">Unggah</button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(window).on('load', function() {
        $('#form-1').trigger('reset');
        $('#form-2').trigger('reset');
        $('#form-3').trigger('reset');
    });

    function previewPembayaran() {
        document.getElementById("preview-pembayaran").style.display = "block";
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("pembayaran").files[0]);

        oFReader.onload = function(oFREvent) {
            document.getElementById("preview-pembayaran").src = oFREvent.target.result;
        };
    }

    function previewLppm() {
        document.getElementById("preview-lppm").style.display = "block";
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("lppm").files[0]);

        oFReader.onload = function(oFREvent) {
            document.getElementById("preview-lppm").src = oFREvent.target.result;
        };
    }

    function previewPerpus() {
        document.getElementById("preview-perpus").style.display = "block";
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("perpus").files[0]);

        oFReader.onload = function(oFREvent) {
            document.getElementById("preview-perpus").src = oFREvent.target.result;
        };
    }

    window.setTimeout(function() {
        $("#div-alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 4000);
</script>
@endpush