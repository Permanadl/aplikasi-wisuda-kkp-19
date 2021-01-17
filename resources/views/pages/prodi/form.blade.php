{!! Form::model($data, [
    'route' => $data->exists ? ['prodi.update', $data->id_prodi] : ['prodi.store'],
    'method' => $data->exists ? 'PUT' : 'POST'
]) !!}

<div class="form-group">
    <label for="" class="control-label">Kode Prodi</label>
    {!! Form::text('id_prodi', null, ['class' => 'form-control form-control-sm', $data->exists ? 'readonly' : '', 'id' => 'id_prodi', 'placeholder' => 'Kode prodi terdiri dari 5 angka']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Nama Prodi</label>
    {!! Form::text('nama_prodi', null, ['class' => 'form-control form-control-sm', 'id' => 'nama_prodi']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Jenjang</label>
    {!! Form::select('jenjang', ['D3' => 'D3', 'S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3'], null, ['class' => 'form-control form-control-sm', 'id' => 'jenjang', 'placeholder' => 'Pilih jenjang']) !!}
</div>

{!! Form::close() !!}