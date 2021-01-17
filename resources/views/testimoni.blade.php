@extends('layouts.main')
@push('css')
@endpush
@section('content')
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-title">Testimoni Wisudawan</h2>
                    </div><!-- /End col -->
                    <!-- <div class="col-md-12 mt-3">
                        <div class="card bg-light filter-card">
                            <div class="card-body">
                                <form class="form-inline justify-content-center">
                                    <div class="form-group mr-2">
                                        <input type="text" id="name" class="form-control" placeholder="Nama Wisudawan">
                                    </div>
                                    <div class="form-group mr-2">
                                        <select id="prodi" class="form-control custom-select">
                                            <option>Pilih Prodi</option>
                                            @foreach($data as $item)
                                            <option value="{{ $item->id_prodi }}">{{ $item->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" id="filter" class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> -->
                </div><!-- /End row -->
            </div>
        </div>
    </div>
    <div class="row mt-3 mb-5" id="testi">

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
</script>
<script>
    $(function() {
        $.ajax({
            url: "{{ route('front.testi') }}",
            method: "POST",
            success: function(data) {
                console.log(data);
                for (var i in data.data) {
                    $('#testi').append('<div class="col-sm-3 col-xs-3 text-center">' +
                        '<div class="card-testi">' +
                        '<div class="card-header text-warning" id="rating-' + data.data[i].id + '"></div>' +
                        '<div class="card-body testi-item mb-5">' +
                        '<p>' + data.data[i].testi + '</p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="testi-footer">' +
                        '<img src="{{ asset("photo/students") }}/' + data.data[i].photo + '" class="img-thumbnail mb-2" alt="">' +
                        '<h2>' + data.data[i].nama_mhs + '</h2>' +
                        '<span>' + data.data[i].nama_prodi + '</span>' +
                        '</div>' +
                        '</div>');
                    for (let a = 0; a <= data.data[i].rating; a++) {
                        $('#rating-' + data.data[i].id).append('<i class="fas fa-star"></i>');
                    }
                }
            }
        });

        $('#filter').click(function() {
            var name = $('#name').val(),
                prodi = $('#prodi').val();
            $.ajax({
                url: "{{ route('front.testi') }}",
                method: "POST",
                success: function(data) {
                    console.log(data);
                    $('#testi').empty();
                }
            });
        });
    })
</script>
@endpush