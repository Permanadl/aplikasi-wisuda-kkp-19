{!! Form::model($data, [
    'route' => ['admin.doReset', $data->id],
    'method' => 'PUT'
]) !!}

<div class="form-group">
    <label for="" class="control-label">Nama Pengguna</label>
    {!! Form::text('username', null, ['class' => 'form-control', 'id' => 'username']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Kata Sandi</label>
    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
</div>

<div class="form-group">
    <label for="" class="control-label">Konfirmasi Kata Sandi</label>
    {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
</div>

{!! Form::close() !!}