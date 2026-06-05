@extends('errors.layout')

@section('title', '419 - Sesi Kadaluarsa')
@section('content')
    <h1>419</h1>
    <h2>Sesi Kadaluarsa</h2>

    <div class="btn-group">
        <a href="{{ url('/login') }}" class="btn btn-primary">Ke Halaman Login</a>
        <a href="{{ url('/') }}" class="btn btn-secondary">Beranda</a>
    </div>
@endsection
