@extends('errors.layout')

@section('title', '404 - Halaman Tidak ditemukan')
@section('content')
    <h1>404</h1>
    <h2>Oops! Halaman tidak ditemukan.</h2>
    <p>Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.</p>

    <a href="{{ url('/') }}" class="btn">Kembali ke Beranda</a>
@endsection
