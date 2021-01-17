@extends('layouts.app')
@section('title', 'Download Format LLDIKTI')
@push('css')

@endpush
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Download Format LLDIKTI</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item">Download</li>
        <li class="breadcrumb-item active" aria-current="page">Format LLDIKTI</li>
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3" style="font-size: 14px;">
                <form action="{{ route('export') }}" class="row col-lg-4" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="tahun" class="form-control" placeholder="Tahun Lulusan">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Download</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')

@endpush