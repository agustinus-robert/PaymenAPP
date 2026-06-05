@extends('auth::layouts.auth')

@section('title', 'Surel terverifikasi | ')

@section('content')
    <h2>Surel terverifikasi</h2>
    <p>Terima kasih telah memverifikasi alamat surel Anda <strong>{{ $user->email_address }}</strong></p>
    <button class="btn btn-soft-danger" style="border: none;" onclick="window.close()">Tutup halaman ini</button>
@endsection
