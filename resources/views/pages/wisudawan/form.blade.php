{!! Form::model($data, [
'route' => $data->exists ? ['wisudawan.update', $data->nim] : ['wisudawan.store'],
'method' => $data->exists ? 'PUT' : 'POST'
]) !!}

<div class="form-group">
    <label for="" class="control-label">NIM</label>
    {!! Form::text('nim', null, ['class' => 'form-control form-control-sm', $data->exists ? 'readonly' : '', 'id' => 'nim', 'placeholder' => 'Misal : A2.1700139']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Nama Wisudawan</label>
    {!! Form::text('nama_mhs', null, ['class' => 'form-control form-control-sm', 'id' => 'nama_mhs']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Jenis Kelamin</label>
    <div class="custom-control custom-radio">
        <div class="row">
            <div class="col-md-6">
                {!! Form::radio('jk', 'L', false, ['class' => 'custom-control-input', 'id' => 'jk-0']) !!}
                <label class="custom-control-label" for="jk-0">Laki-Laki</label>
            </div>
            <div class="col-md-6">
                {!! Form::radio('jk', 'P', false, ['class' => 'custom-control-input', 'id' => 'jk-1']) !!}
                <label class="custom-control-label" for="jk-1">Perempuan</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="" class="control-label">Prodi</label>
    {!! Form::select('id_prodi', $selectProdi, null, ['class' => 'form-control form-control-sm', 'id' => 'id_prodi', 'placeholder' => 'Pilih Prodi']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Judul Skripsi</label>
    {!! Form::textarea('judul_skripsi', null, ['class' => 'form-control form-control-sm', 'id' => 'judul_skripsi', 'rows' => '3']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">IPK</label>
    {!! Form::text('ipk', null, ['class' => 'form-control form-control-sm', 'id' => 'ipk', 'placeholder' => 'Misal : 4.00']) !!}
</div>
@if ($data->exists)
<hr class="hr-text" data-content="Reset Password">
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">
            <input type="checkbox" name="reset">
        </span>
    </div>
    <input type="text" name="password" value="{{ $data->nim.'*Aa' }}" class="form-control" readonly>
</div>
<span class="text text-danger">Catatan : </span>
<p class="text text-danger text-small">Jika pilihan reset di ceklis, maka password wisudawan akan kembali ke password default.</p>
@endif
{!! Form::close() !!}