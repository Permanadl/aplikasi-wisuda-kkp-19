@extends('layouts.app')
@section('title', 'Testimonial')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Testimonial</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Testimonial</li>
    </ol>
</div>
@endsection
@section('content')
<div class="message"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body" id="form">
                <form action="{{ route('testi.store') }}" method="POST">
                    <p>Sampaikan kesan yang menggambarkan perasaan anda selama menempuh pendidikan di STMIK Sumedang</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="rating" id="rating" class="form-control custom-select" {{ $data == NULL ? '' : 'disabled'}}>
                                    <option></option>
                                    <option value="1" {{ $data == NULL ? '' : $data->rating == 1 ? 'selected' : '' }}>Sangat Tidak Puas</option>
                                    <option value="2" {{ $data == NULL ? '' : $data->rating == 2 ? 'selected' : '' }}>Tidak Puas</option>
                                    <option value="3" {{ $data == NULL ? '' : $data->rating == 3 ? 'selected' : '' }}>Netral</option>
                                    <option value="4" {{ $data == NULL ? '' : $data->rating == 4 ? 'selected' : '' }}>Puas</option>
                                    <option value="5" {{ $data == NULL ? '' : $data->rating == 5 ? 'selected' : '' }}>Sangat Puas</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <textarea name="testi" id="testi" class="form-control" rows="10" {{ $data == NULL ? '' : 'readonly'}}>{{$data == NULL ? '' : $data->testimoni}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" align="right">
                        <button type="button" id="btn-save" class="btn btn-primary" @if ($data==NULL) style="display: block;" @else style="display: none;" @endif>Kirim</button>
                        <button type="button" id="btn-ubah" class="btn btn-warning" @if ($data==NULL) style="display: none;" @else style="display: block;" @endif>Ubah</button>
                        <button id="btn-update" type="button" class="btn btn-primary" style="display: none;">Kirim Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.custom-select').select2({
            placeholder: 'Pilih Tingkat Kepuasan Anda'
        });
        window.setTimeout(function() {
            $("#div-alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    });
    $('.message').click(function() {
        $("#div-alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('#btn-save').click(function(e) {
            e.preventDefault();

            var testi = $('#testi').val(),
                rating = $('#rating').val(),
                form = $('#form form');

            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                cache: false,
                data: {
                    'rating': rating,
                    'testi': testi
                },
                success: function(response) {
                    $('#btn-save').css('display', 'none');
                    $('#btn-ubah').css('display', 'block');
                    $('#rating').attr('disabled', 'disabled');
                    $('#testi').attr('readonly', 'readonly');
                    $(".message").html('<div class="row" id="div-alert">' +
                        '<div class="col-lg-12">' +
                        '<div class="mb-4">' +
                        '<div id="alert" class="alert alert-success">' + response.message + '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
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
        $('#btn-ubah').click(function() {
            $('#btn-ubah').css('display', 'none');
            $('#btn-update').css('display', 'block');
            $('#testi').removeAttr('readonly');
            $('#rating').removeAttr('disabled');

            var val = $('#testi').val();
            $('#testi').focus().val('').val(val);
        });
        $('#btn-update').click(function(e) {
            e.preventDefault();

            var testi = $('#testi').val(),
                rating = $('#rating').val(),
                form = $('#form form');
            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');
            $.ajax({
                url: "/testimoni/{{ Session::get('nim') }}",
                method: 'PUT',
                cache: false,
                data: {
                    'rating' : rating,
                    'testi': testi
                },
                success: function(response) {
                    $('#btn-update').css('display', 'none');
                    $('#btn-ubah').css('display', 'block');
                    $('#rating').attr('disabled', 'disabled');
                    $('#testi').attr('readonly', 'readonly');
                    $(".message").html('<div class="row" id="div-alert">' +
                        '<div class="col-lg-12">' +
                        '<div class="mb-4">' +
                        '<div id="alert" class="alert alert-success">' + response.message + '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>');
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
    });
</script>
@endpush