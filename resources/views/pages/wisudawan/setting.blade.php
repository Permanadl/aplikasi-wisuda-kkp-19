@extends('layouts.app')
@section('title', 'Reset Password')
@push('css')
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengaturan Akun</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengaturan Akun</li>
    </ol>
</div>
@endsection
@section('content')
<div class="message"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('wisudawan.doReset', $data->nim) }}" method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">NIM</label>
                                <input type="text" class="form-control" value="{{ $data->nim }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $data->nama_mhs }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Aktifitas Login Terakhir</label>
                                <input type="text" class="form-control" value="{{ $data->last_login }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group" id="for_current">
                                <label for="">Kata Sandi Saat Ini <sup class="text text-danger">*</sup></label>
                                <input type="password" name="current_pass" id="current_pass" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Kata Sandi Baru <sup class="text text-danger">*</sup></label>
                                <input type="password" name="password" id="password" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="">Konfirmasi Kata Sandi <sup class="text text-danger">*</sup></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer" align="right">
                <button type="button" id="btn-save" class="btn btn-primary">Ubah Kata Sandi</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('body').on('click', '#btn-save', function(e) {
            e.preventDefault();

            var form = $('.card-body form'),
                current_pass = $('#current_pass').val(),
                password = $('#password').val(),
                password_confirmation = $('#password_confirmation').val();
            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                cache: false,
                data: {
                    'current_pass': current_pass,
                    'password': password,
                    'password_confirmation': password_confirmation
                },
                success: function(response) {
                    if (response.success == true) {
                        $(".message").html('<div class="row" id="div-alert">' +
                            '<div class="col-lg-12">' +
                            '<div class="mb-4">' +
                            '<div id="alert" class="alert alert-success">' + response.message + '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                    } else {
                        $("#current_pass").addClass('is-invalid');
                        $("#for_current").append('<div class="invalid-feedback">' + response.message + '</div>');
                    }

                    console.log(response);
                },
                error: function(response) {
                    var res = response.responseJSON;

                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(key, value) {
                            $('#' + key)
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .closest('.form-group')
                                .append('<div class="invalid-feedback">' + value + '</div>')
                        });
                    }
                    console.log(response);
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