{!! Form::model($data, [
    'route' => $data->exists ? ['admin.update', $data->id] : ['admin.store'],
    'method' => $data->exists ? 'PUT' : 'POST'
]) !!}

<div class="form-group">
    <label for="" class="control-label">Nama Administrator</label>
    {!! Form::text('nama_admin', null, ['class' => 'form-control form-control-sm', 'id' => 'nama_admin']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Nama Pengguna</label>
    {!! Form::text('username', null, ['class' => 'form-control form-control-sm', 'id' => 'username']) !!}
</div>
@if ($data->exists == false)
<div class="form-group">
    <label for="" class="control-label">Kata Sandi</label>
    {!! Form::password('password', ['class' => 'form-control form-control-sm', 'id' => 'password']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Konfirmasi Kata Sandi</label>
    {!! Form::password('password_confirmation', ['class' => 'form-control form-control-sm', 'id' => 'password_confirmation']) !!}
</div>
@endif

{!! Form::close() !!}