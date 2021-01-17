@extends('layouts.main')
@push('css')

@endpush
@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body bg-light">
                    <img src="{{ $data->photo == NULL ? asset('photo/students/default.jpg') : asset('photo/students/'.$data->photo) }}" alt="">
                </div>
                <div class="card-footer profile-footer">
                    <h2>{{ $data->nama_mhs }}</h2>
                    <span>{{ $data->email }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card bg-light">
                <div class="card-header bg-yellow">
                    Data Wisudawan
                </div>
                <div class="card-body mb-4 data-container">
                    <h4 class="title mb-3">A. INFO PRIBADI</h4>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->nim }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->nama_mhs }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->tempat_lahir }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal Lahir </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->tgl_lahir }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nomor Kontak</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->no_hp }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">E-mail</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <textarea class="form-control form-control-plaintext" readonly
                                disabled>{{ $data->alamat }}</textarea>
                        </div>
                    </div>
                    <h4 class="title mb-3 mt-3">B. DATA PERKULIAHAN</h4>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Prodi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->nama_prodi }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">IPK</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" readonly disabled
                                value="{{ $data->ipk }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Judul Skripsi</label>
                        <div class="col-sm-9">
                            <textarea class="form-control form-control-plaintext" readonly
                                disabled>{{ $data->judul_skripsi }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush
