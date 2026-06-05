@extends('auth::layouts.auth')

@section('title', 'Permintaan otorisasi | ')

@section('content')
    <h2>Permintaan otorisasi</h2>
    <p class="text-muted mb-4">Halo! Aplikasi <strong>{{ $client->name }}</strong> meminta izin untuk mengakses akun Anda.</p>
    @if (count($scopes) > 0)
        <div class="scopes">
            <p><strong>Aplikasi ini akan dapat mengakses:</strong></p>
            <ul class="ps-3">
                @foreach ($scopes as $scope)
                    <li>{{ $scope->description }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div>
        <form class="form-block d-inline py-4" method="post" action="{{ route('passport.authorizations.approve') }}"> @csrf
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button type="submit" class="btn btn-danger px-3"><i class="mdi mdi-check"></i> Ya, izinkan.</button>
        </form>
        <form class="form-block d-inline py-4" method="post" action="{{ route('passport.authorizations.deny') }}"> @csrf @method('DELETE')
            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button class="btn btn-ghost-light text-dark px-3"><i class="mdi mdi-close"></i> Tolak</button>
        </form>
    </div>
@endsection
