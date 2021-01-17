{!! Form::model($data, [
    'route' => $data->exists ? ['wisuda.update', $data->tahun] : ['wisuda.store'],
    'method' => $data->exists ? 'PUT' : 'POST'
]) !!}

<div class="form-group">
    <label for="" class="control-label">Tahun</label>
    {!! Form::text('tahun', $data->exists ? null : date('Y'), [$data->exists ? 'readonly' : '', 'class' => 'form-control form-control-sm', 'id' => 'tahun', 'placeholder' => 'Tahun Pelaksanaan']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Angkatan Ke-</label>
    {!! Form::number('angkatan', null, [$data->exists ? 'readonly' : '', 'class' => 'form-control form-control-sm', 'id' => 'angkatan', 'placeholder' => 'Isi dengan angka']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Tanggal Wisuda</label>
    {!! Form::date('tgl_wisuda', null, ['class' => 'form-control form-control-sm', 'id' => 'tgl_wisuda']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Tanggal Yudisium</label>
    {!! Form::date('tgl_yudisium', null, ['class' => 'form-control form-control-sm', 'id' => 'tgl_yudisium']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Tempat</label>
    {!! Form::text('tempat', null, ['class' => 'form-control form-control-sm', 'id' => 'tempat', 'placeholder' => 'Tempat Pelaksanaan']) !!}
</div>

{!! Form::close() !!}