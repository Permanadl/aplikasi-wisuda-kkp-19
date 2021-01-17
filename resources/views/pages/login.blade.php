<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi Wisuda">
  <meta name="author" content="Kelompok KP 19">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('img/logo/logo.png') }}" rel="icon">
  <title>Halaman Login | Aplikasi Wisuda</title>
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/app-wisuda.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">SILAHKAN LOGIN</h1>
                  </div>
                  <div class="user" id="formMhs">
                    <div class="form-group">
                      <input type="text" class="form-control" id="nim" aria-describedby="emailHelp" placeholder="NIM">
                      <div class="invalid-feedback" id="fornim"></div>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password-mhs" placeholder="Kata Sandi">
                      <div class="invalid-feedback" id="forpassword-mhs"></div>
                    </div>
                    <div class="text-center" style="margin-bottom: 10px;">
                      <span class="text text-danger" id="msg"></span>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-warning btn-block btn-login-mhs">Masuk</button>
                    </div>
                  </div>
                  <div class="user" id="formAdm" style="display: none;">
                    <div class="form-group">
                      <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Nama Pengguna">
                      <div class="invalid-feedback" id="forusername-admin"></div>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="password-admin" placeholder="Kata Sandi">
                      <div class="invalid-feedback" id="forpassword-admin"></div>
                    </div>
                    <div class="text-center" style="margin-bottom: 10px;">
                      <span class="text text-danger" id="msg-admin"></span>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-warning btn-block btn-login-admin">Masuk</button>
                    </div>
                  </div>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small text-warning" href="javascript:void(0)" onclick="toggle()" id="toggle">Masuk sebagai admin</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/app-wisuda.min.js') }}"></script>
  <script>
    function toggle() {
      var mhs = document.getElementById('formMhs');
      var adm = document.getElementById('formAdm');
      var link = document.getElementById('toggle');
      if (mhs.style.display === 'none') {
        document.getElementById('nim').value = '';
        document.getElementById('password-mhs').value = '';
        mhs.style.display = 'block';
        adm.style.display = 'none';
        link.innerHTML = 'Masuk sebagai admin';
      } else {
        document.getElementById('username').value = '';
        document.getElementById('password-admin').value = '';
        mhs.style.display = 'none';
        adm.style.display = 'block';
        link.innerHTML = 'Masuk sebagai mahasiswa';
      }
    }
  </script>
  <script>
    $(document).ready(function() {
      $("#username").keyup(function() {
        $("#username").removeClass("is-invalid");
      });
      $("#password-admin").keyup(function() {
        $("#password-admin").removeClass("is-invalid");
      });
      $("#nim").keyup(function() {
        $("#nim").removeClass("is-invalid");
      });
      $("#password-mhs").keyup(function() {
        $("#password-mhs").removeClass("is-invalid");
      });
      $(".btn-login-admin").click(function() {
        var username = $("#username").val();
        var password = $("#password-admin").val();
        var token = $("meta[name='csrf-token']").attr("content");

        if (username.length == "" && password.length == "") {
          $("#username").addClass("is-invalid");
          $("#forusername-admin").html('Nama pengguna tidak boleh kosong');
          $("#password-admin").addClass("is-invalid");
          $("#forpassword-admin").html('Kata sandi tidak boleh kosong');
          $("#msg-admin").html('');
        } else if (username.length != "" && password.length == "") {
          $("#username").removeClass("is-invalid");
          $("#forusername-admin").html('');
          $("#password-admin").addClass("is-invalid");
          $("#forpassword-admin").html('Kata sandi tidak boleh kosong');
          $("#msg-admin").html('');
        } else if (username.length == "" && password.length != "") {
          $("#password-admin").removeClass("is-invalid");
          $("#forpassword-admin").html('');
          $("#username").addClass("is-invalid");
          $("#forusername-admin").html('Nama pengguna tidak boleh kosong');
          $("#msg-admin").html('');
        } else {
          $.ajax({
            url: "{{ route('login.admin') }}",
            type: "POST",
            dataType: "JSON",
            cache: false,
            data: {
              "username": username,
              "password": password,
              "_token": token
            },
            success: function(response) {
              if (response.success) {
                window.location.href = "{{ url('dashboard') }}"
              } else {
                console.log(response.success);
              }
              console.log(response);
            },
            error: function(status, response) {
              $("#username").removeClass("is-invalid");
              $("#password-admin").removeClass("is-invalid");
              $("#forusername-admin").html('');
              $("#forpassword-admin").html('');
              var status = JSON.parse(status.responseText);
              $("#msg-admin").html(status.message);
              console.log(status);
            }
          });
        }
      });
      $(".btn-login-mhs").click(function() {
        var nim = $("#nim").val();
        var password = $("#password-mhs").val();
        var token = $("meta[name='csrf-token']").attr("content");

        if (nim.length == "" && password.length == "") {
          $("#nim").addClass("is-invalid");
          $("#fornim").html('NIM tidak boleh kosong');
          $("#password-mhs").addClass("is-invalid");
          $("#forpassword-mhs").html('Kata sandi tidak boleh kosong');
          $("#msg").html('');
        } else if (nim.length != "" && password.length == "") {
          $("#nim").removeClass("is-invalid");
          $("#fornim").html('');
          $("#password-mhs").addClass("is-invalid");
          $("#forpassword-mhs").html('Kata sandi tidak boleh kosong');
          $("#msg").html('');
        } else if (nim.length == "" && password.length != "") {
          $("#password-mhs").removeClass("is-invalid");
          $("#forpassword-mhs").html('');
          $("#nim").addClass("is-invalid");
          $("#fornim").html('NIM tidak boleh kosong');
          $("#msg").html('');
        } else {
          $.ajax({
            url: "{{ route('login.student') }}",
            type: "POST",
            dataType: "JSON",
            cache: false,
            data: {
              "nim": nim,
              "password": password,
              "_token": token
            },
            success: function(response) {
              if (response.success) {
                window.location.href = "{{ url('dashboard') }}"
              } else {
                console.log(response.success);
              }
              console.log(response);
            },
            error: function(status, response) {
              $("#nim").removeClass("is-invalid");
              $("#password-mhs").removeClass("is-invalid");
              $("#fornim").html('');
              $("#forpassword-mhs").html('');
              var status = JSON.parse(status.responseText);
              $("#msg").html(status.message);
              console.log(status);
            }
          });
        }
      });
    });
  </script>
</body>

</html>