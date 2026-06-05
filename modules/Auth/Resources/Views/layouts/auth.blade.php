@extends('layouts.guest')

@section('titleTemplate', config('modules.auth.name'))

@section('bodyclass', 'bg-home')

@section('main')
    <div style="background: #000a; height: 100%; width: 100%; position: absolute; z-index: -1;"></div>
    <div class="container-fluid">
        <div class="row min-vh-100 row justify-content-center align-items-center mx-0">
            <div class="col-xxl-4 col-xl-6 col-lg-7 col-md-8">
                <div class="card card-body auth-card rounded-3 border-0 p-0">
                    <main class="p-sm-5 p-4" style="min-height: 600px;">
                        <x-alert-success></x-alert-success>
                        <x-alert-danger></x-alert-danger>
                        <div class="pt-2">
                            <div class="animate__animated animate__fadeIn animate__faster">
                                @yield('content')
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-home {
            background: url("{{ asset('img/home~1.jpg') }}") center center no-repeat;
            background-size: cover;
            backdrop-filter: blur(16px);
        }

        .auth-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, .975);
        }
    </style>
@endpush
