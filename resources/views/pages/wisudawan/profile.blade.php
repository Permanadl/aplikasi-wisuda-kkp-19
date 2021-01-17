@extends('layouts.app')
@section('title', 'Wisudawan')
@push('css')
<style type="text/css">
    .card-body input {
        border: none;
    }

    .card-body input:hover {
        border: none;
    }

    .card-body input:focus {
        border: none;
    }

    .card-body input:read-only {
        background-color: transparent;
    }

    .card-body textarea {
        border: none;
    }

    .card-body textarea:hover {
        border: none;
    }

    .card-body textarea:focus {
        border: none;
    }

    .card-body textarea:read-only {
        background-color: transparent;
    }

    .card-body hr {
        margin-top: -4px;
    }
</style>
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profil Wisudawan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Profil</li>
        <li class="breadcrumb-item active" aria-current="page">{{ Session::get('nama') }}</li>
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
<div class="message"></div>
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="image">
                <img src="{{ $data->photo == NULL ? asset('photo/students/default.jpg') : asset('photo/students/'.$data->photo)  }}" alt="" style="width: 100%;">
            </div>
            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#unggah-photo">Unggah Photo</button>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card mb-4">
            <div class="card-header">

            </div>
            <div class="card-body" id="profile">
                <form id="form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <input type="text" id="nim" class="form-control" readonly>
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="nama_mhs">Nama Wisudawan</label>
                                <sup class="text text-danger"><b>*</b></sup>
                                <input type="text" id="nama_mhs" name="nama_mhs" class="form-control">
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <sup class="text text-danger"><b>*</b></sup>
                                <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control">
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <sup class="text text-danger"><b>*</b></sup>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control">
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_hp">No Handphone</label>
                                <sup class="text text-danger"><b>*</b></sup>
                                <input type="text" id="no_hp" name="no_hp" class="form-control">
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <sup class="text text-danger"><b>*</b></sup>
                                <input type="text" id="email" name="email" class="form-control">
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <sup class="text text-danger"><b>*</b></sup>
                                <textarea name="" id="alamat" name="alamat" class="form-control" rows="4"></textarea>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ipk">IPK</label>
                                <input type="text" id="ipk" class="form-control" readonly>
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="judul_skripsi">Judul Skripsi</label>
                                <textarea name="" id="judul_skripsi" class="form-control" rows="4" readonly></textarea>
                                <hr>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer" align="right">
                <button class="btn btn-primary" id="save">Perbarui Profil</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="unggah-photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah Pass Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('unggah.photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Pilih berkas</label>
                        <input type="file" accept="image/jpeg" name="photo" class="form-control-file" id="exampleFormControlFile1" required>
                    </div>
                    <p class="text text-danger">File harus berekstensi jpg.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Unggah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $("#nim").val('{{ $data->nim }}');
        $("#nama_mhs").val('{{ $data->nama_mhs }}');
        $("#tempat_lahir").val('{{ $data->tempat_lahir }}');
        $("#tgl_lahir").val('{{ $data->tgl_lahir }}');
        $("#no_hp").val('{{ $data->no_hp }}');
        $("#email").val('{{ $data->email }}');
        $("#alamat").val('{{ $data->alamat }}');
        $("#ipk").val('{{ $data->ipk }}');
        $("#judul_skripsi").val('{{ $data->judul_skripsi }}');

        $("#save").click(function(event) {
            event.preventDefault();
            var nama_mhs = $("#nama_mhs").val();
            var tempat_lahir = $("#tempat_lahir").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var no_hp = $("#no_hp").val();
            var email = $("#email").val();
            var alamat = $("#alamat").val();
            $.ajax({
                url: '/profile/{{ $data->nim }}',
                method: 'POST',
                cache: false,
                data: {
                    'nama_mhs': nama_mhs,
                    'tempat_lahir': tempat_lahir,
                    'tgl_lahir': tgl_lahir,
                    'no_hp': no_hp,
                    'email': email,
                    'alamat': alamat,
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
                    }, 3000)
                    console.log(response);
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
            });
        });

        window.setTimeout(function() {
            $("#div-alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 4000);
    });
</script>
@endpush