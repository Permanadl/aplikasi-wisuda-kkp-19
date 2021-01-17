<form action="" class="form-show">
    <div class="form-group">
        <div class="img-container" align="center">
            <img class="img-profile" src="{{ $data->photo == NULL ? asset('photo/students/default.jpg') : asset('photo/students/'.$data->photo)  }}" alt="" style="width: 30%;">
        </div>
        <center class="identify">{{ $data->nama_mhs }} - {{ $data->nim }}</center>
        <center>{{ $data->nama_prodi }}</center>
    </div>
    <hr>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Jenis Kelamin</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Tempat Lahir</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->tempat_lahir == NULL ? '-' : $data->tempat_lahir }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Tanggal Lahir</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->tgl_lahir == NULL ? '-' : $data->tgl_lahir }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Email</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->email == NULL ? '-' : $data->email }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">No. Handphone</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->no_hp == NULL ? '-' : $data->no_hp }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Alamat</label>
        <textarea class="form-control-plaintext" readonly>{{ $data->alamat == NULL ? '-' : $data->alamat }}</textarea>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Tahun Lulus</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->tahun }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">IPK</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->ipk }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Judul Skripsi</label>
        <textarea class="form-control-plaintext" readonly>{{ $data->judul_skripsi }}</textarea>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Perubahan Terakhir</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->updated_at }}" readonly>
        <hr>
    </div>
    <div class="form-group">
        <label for="" style="font-weight: bold;">Aktifitas Login Terkahir</label>
        <input type="text" class="form-control-plaintext" value="{{ $data->last_login }}" readonly>
        <hr>
    </div>
</form>