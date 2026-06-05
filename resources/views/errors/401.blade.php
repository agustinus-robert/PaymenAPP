@extends('errors.layout')

@section('title', '401 - Akses Ditolak')
@section('content')
    <h1>401</h1>
    <h2>Akses Ditolak.</h2>
    <p>Anda tidak memiliki izin (belum login) untuk mengakses halaman ini. Silakan masuk ke akun Anda terlebih dahulu.</p>

    <div class="btn-group">
        <a href="{{ url('/login') }}" class="btn btn-primary">Ke Halaman Login</a>
        <a href="{{ url('/') }}" class="btn btn-secondary">Beranda</a>
    </div>
@endsection
