@extends('account::layouts.default')

@section('title', 'Akun saya | ')

@php
    $user = Auth::user();
    $important_updates = [
        'nulled_password' => is_null($user->password) && $user->email_verified_at,
        'filled_profile' => is_null($user->getMeta('contact_number')),
    ];
@endphp

@section('content')
    <nav class="absolute top-0 z-50 flex w-full flex-wrap items-center justify-between px-2 py-3">
        <div class="container mx-auto flex flex-wrap items-center justify-between px-4">
            <div class="relative flex w-full justify-between lg:static lg:block lg:w-auto lg:justify-start">
                <a class="mr-4 inline-block whitespace-nowrap py-2 text-sm font-bold uppercase leading-relaxed text-white" href="https://www.creative-tim.com/learning-lab/tailwind-starter-kit#/presentation">Portal</a><button class="block cursor-pointer rounded border border-solid border-transparent bg-transparent px-3 py-1 text-xl leading-none outline-none focus:outline-none lg:hidden" type="button" onclick="toggleNavbar('example-collapse-navbar')">
                    <i class="fas fa-bars text-white"></i>
                </button>
            </div>
            <div class="hidden flex-grow items-center bg-white lg:flex lg:bg-transparent lg:shadow-none" id="example-collapse-navbar">

                <ul class="flex list-none flex-col lg:ml-auto lg:flex-row">
                    <!-- Dropdown Menu -->
                    <li class="relative mr-5">
                        <!-- Trigger Button -->
                        <button class="flex items-center p-2 text-gray-700 hover:text-gray-900 focus:outline-none" type="button" onclick="toggleDropdown(this)">
                            <i class="mdi mdi-apps text-lg text-white"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div style="margin-left:-90px;" class="absolute top-full z-50 mt-2 hidden w-80 transform rounded-lg border bg-white p-3 shadow-md" id="dropdown-menu">
                            <div class="flex justify-between">
                                <!-- Item 1 -->
                                <div class="mr-6 text-center">
                                    <a class="flex flex-col items-center text-gray-700 hover:text-gray-900" href="https://spots.test">
                                        <span class="mdi mdi-food-fork-drink mb-1 text-2xl"></span>
                                        <span class="text-sm">Resto</span>
                                    </a>
                                </div>

                                <!-- Item 2 -->
                                <div class="mr-6 text-center">
                                    <a class="flex flex-col items-center text-gray-700 hover:text-gray-900" href="https://spots.test">
                                        <span class="mdi mdi-laptop mb-1 text-2xl"></span>
                                        <span class="text-sm">Elektronik</span>
                                    </a>
                                </div>

                                <!-- Item 3 -->
                                <div class="text-center">
                                    <a class="flex flex-col items-center text-gray-700 hover:text-gray-900" href="https://spots.test">
                                        <span class="mdi mdi-tshirt-crew mb-1 text-2xl"></span>
                                        <span class="text-sm">Fashion</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>




                    <li class="flex items-center">
                        <a class="flex items-center px-3 py-4 text-xs font-bold uppercase text-gray-800 lg:py-2 lg:text-white lg:hover:text-gray-300" href="#pablo"><i class="fab fa-facebook leading-lg text-lg text-gray-500 lg:text-gray-300"></i><span class="ml-2 inline-block lg:hidden">Share</span></a>
                    </li>
                    <li class="flex items-center">
                        <a class="flex items-center px-3 py-4 text-xs font-bold uppercase text-gray-800 lg:py-2 lg:text-white lg:hover:text-gray-300" href="#pablo"><i class="fab fa-twitter leading-lg text-lg text-gray-500 lg:text-gray-300"></i><span class="ml-2 inline-block lg:hidden">Tweet</span></a>
                    </li>
                    <li class="flex items-center">
                        <a class="flex items-center px-3 py-4 text-xs font-bold uppercase text-gray-800 lg:py-2 lg:text-white lg:hover:text-gray-300" href="#pablo"><i class="fab fa-github leading-lg text-lg text-gray-500 lg:text-gray-300"></i><span class="ml-2 inline-block lg:hidden">Star</span></a>
                    </li>

                    <li class="flex items-center">
                        <a href="javascript:;" onclick="signout()" class="flex items-center px-3 py-4 text-xs font-bold uppercase text-gray-800 lg:py-2 lg:text-white lg:hover:text-gray-300" href="#pablo"><i class="fas fa-sign-out-alt leading-lg text-lg text-gray-500 lg:text-gray-300"></i><span class="ml-2 inline-block lg:hidden">Star</span></a>
                    </li>


                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="relative flex content-center items-center justify-center pb-32 pt-16" style="min-height: 75vh;">
            <div class="absolute top-0 h-full w-full bg-cover bg-center" style='background-image: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1267&amp;q=80");'>
                <span id="blackOverlay" class="absolute h-full w-full bg-black opacity-75"></span>
            </div>
            <div class="container relative mx-auto">
                <div class="flex flex-wrap items-center">
                    <div class="ml-auto mr-auto w-full px-4 text-center lg:w-6/12">
                        <div class="pr-12">
                            <h1 class="text-5xl font-semibold text-white">
                                Nikmati Kemudahan Integrasi
                            </h1>
                            <p class="mt-4 text-lg text-gray-300">
                                Halaman portal ini memiliki 3 modul utama untuk mengelola Penjualan, Pengelolaan Company Profile, dan CRM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pointer-events-none absolute bottom-0 left-0 right-0 top-auto w-full overflow-hidden" style="height: 70px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="fill-current text-gray-300" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <section class="-mt-24 bg-gray-300 pb-20">
            <div class="container mx-auto px-4">

                <div class="flex flex-wrap">

                    <div class="w-full px-4 pt-6 text-center md:w-4/12 lg:pt-12">
                        <a href="{{ route('admin::dashboard-cms') }}">
                            <div class="relative mb-8 flex w-full min-w-0 flex-col break-words rounded-lg bg-white shadow-lg">
                                <div class="flex-auto px-4 py-5">
                                    <div class="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-full bg-red-400 p-3 text-center text-white shadow-lg">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <h6 class="text-xl font-semibold">Modul Compro</h6>
                                    <p class="mb-4 mt-2 text-gray-600">
                                        Sesuaikan konten halaman depan anda, dan anda bisa mengubah nama identitas website anda.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>


                    <div class="w-full px-4 text-center md:w-4/12">
                        <a href="{{ route('poz::dashboard') }}">
                            <div class="relative mb-8 flex w-full min-w-0 flex-col break-words rounded-lg bg-white shadow-lg">
                                <div class="flex-auto px-4 py-5">
                                    <div class="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-full bg-blue-400 p-3 text-center text-white shadow-lg">
                                        <i class="fas fa-retweet"></i>
                                    </div>
                                    <h6 class="text-xl font-semibold">Modul Penjualan</h6>
                                    <p class="mb-4 mt-2 text-gray-600">
                                        Kelola penjualan anda, dari mulai purchase, selling, dan reporting pada toko anda.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="w-full px-4 pt-6 text-center md:w-4/12">
                        <a href="https://drive.google.com/file/d/1DyFqjeYnaUasM3tQgDv6DYoIe2WXOMHd/view?usp=sharing">
                            <div class="relative mb-8 flex w-full min-w-0 flex-col break-words rounded-lg bg-white shadow-lg">
                                <div class="flex-auto px-4 py-5">
                                    <div class="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-full bg-green-400 p-3 text-center text-white shadow-lg">
                                        <i class="fas fa-fingerprint"></i>
                                    </div>
                                    <h6 class="text-xl font-semibold">Aplikasi Penjualan POS</h6>
                                    <p class="mb-4 mt-2 text-gray-600">
                                        Nikmati kemudahan lewat aplikasi untuk transaksi!
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="mt-32 flex flex-wrap items-center">
                    <div class="ml-auto mr-auto w-full px-4 md:w-5/12">
                        <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 p-3 text-center text-gray-600 shadow-lg">
                            <i class="fas fa-user-friends text-xl"></i>
                        </div>
                        <h3 class="mb-2 text-3xl font-semibold leading-normal">
                            Working with us is a pleasure
                        </h3>
                        <p class="mb-4 mt-4 text-lg font-light leading-relaxed text-gray-700">
                            Don't let your uses guess by attaching tooltips and popoves to
                            any element. Just make sure you enable them first via
                            JavaScript.
                        </p>
                        <p class="mb-4 mt-0 text-lg font-light leading-relaxed text-gray-700">
                            The kit comes with three pre-built pages to help you get started
                            faster. You can change the text and images and you're good to
                            go. Just make sure you enable them first via JavaScript.
                        </p>
                        <a href="https://www.creative-tim.com/learning-lab/tailwind-starter-kit#/presentation" class="mt-8 font-bold text-gray-800">Check Tailwind Starter Kit!</a>
                    </div>
                    <div class="ml-auto mr-auto w-full px-4 md:w-4/12">
                        <div class="relative mb-6 flex w-full min-w-0 flex-col break-words rounded-lg bg-pink-600 bg-white shadow-lg">
                            <img alt="..." src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1051&amp;q=80" class="w-full rounded-t-lg align-middle" />
                            <blockquote class="relative mb-4 p-8">
                                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 583 95" class="absolute left-0 block w-full" style="height: 95px; top: -94px;">
                                    <polygon points="-30,95 583,95 583,65" class="fill-current text-pink-600"></polygon>
                                </svg>
                                <h4 class="text-xl font-bold text-white">
                                    Top Notch Services
                                </h4>
                                <p class="text-md mt-2 font-light text-white">
                                    The Arctic Ocean freezes every winter and much of the
                                    sea-ice then thaws every summer, and that process will
                                    continue whatever happens.
                                </p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="relative py-20">
            <div class="pointer-events-none absolute bottom-auto left-0 right-0 top-0 -mt-20 w-full overflow-hidden" style="height: 80px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="fill-current text-white" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-center">
                    <div class="ml-auto mr-auto w-full px-4 md:w-4/12">
                        <img alt="..." class="max-w-full rounded-lg shadow-lg" src="https://images.unsplash.com/photo-1555212697-194d092e3b8f?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=634&amp;q=80" />
                    </div>
                    <div class="ml-auto mr-auto w-full px-4 md:w-5/12">
                        <div class="md:pr-12">
                            <div class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full bg-pink-300 p-3 text-center text-pink-600 shadow-lg">
                                <i class="fas fa-rocket text-xl"></i>
                            </div>
                            <h3 class="text-3xl font-semibold">A growing company</h3>
                            <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                The extension comes with three pre-built pages to help you get
                                started faster. You can change the text and images and you're
                                good to go.
                            </p>
                            <ul class="mt-6 list-none">
                                <li class="py-2">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="mr-3 inline-block rounded-full bg-pink-200 px-2 py-1 text-xs font-semibold uppercase text-pink-600"><i class="fas fa-fingerprint"></i></span>
                                        </div>
                                        <div>
                                            <h4 class="text-gray-600">
                                                Carefully crafted components
                                            </h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="mr-3 inline-block rounded-full bg-pink-200 px-2 py-1 text-xs font-semibold uppercase text-pink-600"><i class="fab fa-html5"></i></span>
                                        </div>
                                        <div>
                                            <h4 class="text-gray-600">Amazing page examples</h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="flex items-center">
                                        <div>
                                            <span class="mr-3 inline-block rounded-full bg-pink-200 px-2 py-1 text-xs font-semibold uppercase text-pink-600"><i class="far fa-paper-plane"></i></span>
                                        </div>
                                        <div>
                                            <h4 class="text-gray-600">Dynamic components</h4>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="pb-48 pt-20">
            <div class="container mx-auto px-4">
                <div class="mb-24 flex flex-wrap justify-center text-center">
                    <div class="w-full px-4 lg:w-6/12">
                        <h2 class="text-4xl font-semibold">Here are our heroes</h2>
                        <p class="m-4 text-lg leading-relaxed text-gray-600">
                            According to the National Oceanic and Atmospheric
                            Administration, Ted, Scambos, NSIDClead scentist, puts the
                            potentially record maximum.
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="mb-12 w-full px-4 md:w-6/12 lg:mb-0 lg:w-3/12">
                        <div class="px-6">
                            <img alt="..." src="./assets/img/team-1-800x800.jpg" class="mx-auto max-w-full rounded-full shadow-lg" style="max-width: 120px;" />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Ryan Tompson</h5>
                                <p class="mt-1 text-sm font-semibold uppercase text-gray-500">
                                    Web Developer
                                </p>
                                <div class="mt-6">
                                    <button class="mb-1 mr-1 h-8 w-8 rounded-full bg-blue-400 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-twitter"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-blue-600 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-facebook-f"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-pink-500 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-dribbble"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-12 w-full px-4 md:w-6/12 lg:mb-0 lg:w-3/12">
                        <div class="px-6">
                            <img alt="..." src="./assets/img/team-2-800x800.jpg" class="mx-auto max-w-full rounded-full shadow-lg" style="max-width: 120px;" />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Romina Hadid</h5>
                                <p class="mt-1 text-sm font-semibold uppercase text-gray-500">
                                    Marketing Specialist
                                </p>
                                <div class="mt-6">
                                    <button class="mb-1 mr-1 h-8 w-8 rounded-full bg-red-600 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-google"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-blue-600 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-12 w-full px-4 md:w-6/12 lg:mb-0 lg:w-3/12">
                        <div class="px-6">
                            <img alt="..." src="./assets/img/team-3-800x800.jpg" class="mx-auto max-w-full rounded-full shadow-lg" style="max-width: 120px;" />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Alexa Smith</h5>
                                <p class="mt-1 text-sm font-semibold uppercase text-gray-500">
                                    UI/UX Designer
                                </p>
                                <div class="mt-6">
                                    <button class="mb-1 mr-1 h-8 w-8 rounded-full bg-red-600 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-google"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-blue-400 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-twitter"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-gray-800 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-instagram"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-12 w-full px-4 md:w-6/12 lg:mb-0 lg:w-3/12">
                        <div class="px-6">
                            <img alt="..." src="./assets/img/team-4-470x470.png" class="mx-auto max-w-full rounded-full shadow-lg" style="max-width: 120px;" />
                            <div class="pt-6 text-center">
                                <h5 class="text-xl font-bold">Jenna Kardi</h5>
                                <p class="mt-1 text-sm font-semibold uppercase text-gray-500">
                                    Founder and CEO
                                </p>
                                <div class="mt-6">
                                    <button class="mb-1 mr-1 h-8 w-8 rounded-full bg-pink-500 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-dribbble"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-red-600 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-google"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-blue-400 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-twitter"></i></button><button class="mb-1 mr-1 h-8 w-8 rounded-full bg-gray-800 text-white outline-none focus:outline-none" type="button">
                                        <i class="fab fa-instagram"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="relative block bg-gray-900 pb-20">
            <div class="pointer-events-none absolute bottom-auto left-0 right-0 top-0 -mt-20 w-full overflow-hidden" style="height: 80px;">
                <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                    <polygon class="fill-current text-gray-900" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <div class="container mx-auto px-4 lg:pb-64 lg:pt-24">
                <div class="flex flex-wrap justify-center text-center">
                    <div class="w-full px-4 lg:w-6/12">
                        <h2 class="text-4xl font-semibold text-white">Build something</h2>
                        <p class="mb-4 mt-4 text-lg leading-relaxed text-gray-500">
                            Put the potentially record low maximum sea ice extent tihs year
                            down to low ice. According to the National Oceanic and
                            Atmospheric Administration, Ted, Scambos.
                        </p>
                    </div>
                </div>
                <div class="mt-12 flex flex-wrap justify-center">
                    <div class="w-full px-4 text-center lg:w-3/12">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white p-3 text-gray-900 shadow-lg">
                            <i class="fas fa-medal text-xl"></i>
                        </div>
                        <h6 class="mt-5 text-xl font-semibold text-white">
                            Excelent Services
                        </h6>
                        <p class="mb-4 mt-2 text-gray-500">
                            Some quick example text to build on the card title and make up
                            the bulk of the card's content.
                        </p>
                    </div>
                    <div class="w-full px-4 text-center lg:w-3/12">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white p-3 text-gray-900 shadow-lg">
                            <i class="fas fa-poll text-xl"></i>
                        </div>
                        <h5 class="mt-5 text-xl font-semibold text-white">
                            Grow your market
                        </h5>
                        <p class="mb-4 mt-2 text-gray-500">
                            Some quick example text to build on the card title and make up
                            the bulk of the card's content.
                        </p>
                    </div>
                    <div class="w-full px-4 text-center lg:w-3/12">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-white p-3 text-gray-900 shadow-lg">
                            <i class="fas fa-lightbulb text-xl"></i>
                        </div>
                        <h5 class="mt-5 text-xl font-semibold text-white">Launch time</h5>
                        <p class="mb-4 mt-2 text-gray-500">
                            Some quick example text to build on the card title and make up
                            the bulk of the card's content.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section class="relative block bg-gray-900 py-24 lg:pt-0">
            <div class="container mx-auto px-4">
                <div class="-mt-48 flex flex-wrap justify-center lg:-mt-64">
                    <div class="w-full px-4 lg:w-6/12">
                        <div class="relative mb-6 flex w-full min-w-0 flex-col break-words rounded-lg bg-gray-300 shadow-lg">
                            <div class="flex-auto p-5 lg:p-10">
                                <h4 class="text-2xl font-semibold">Want to work with us?</h4>
                                <p class="mb-4 mt-1 leading-relaxed text-gray-600">
                                    Complete this form and we will get back to you in 24 hours.
                                </p>
                                <div class="relative mb-3 mt-8 w-full">
                                    <label class="mb-2 block text-xs font-bold uppercase text-gray-700" for="full-name">Full Name</label><input type="text" class="w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-700 placeholder-gray-400 shadow focus:outline-none focus:ring" placeholder="Full Name" style="transition: all 0.15s ease 0s;" />
                                </div>
                                <div class="relative mb-3 w-full">
                                    <label class="mb-2 block text-xs font-bold uppercase text-gray-700" for="email">Email</label><input type="email" class="w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-700 placeholder-gray-400 shadow focus:outline-none focus:ring" placeholder="Email" style="transition: all 0.15s ease 0s;" />
                                </div>
                                <div class="relative mb-3 w-full">
                                    <label class="mb-2 block text-xs font-bold uppercase text-gray-700" for="message">Message</label>
                                    <textarea rows="4" cols="80" class="w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-700 placeholder-gray-400 shadow focus:outline-none focus:ring" placeholder="Type a message..."></textarea>
                                </div>
                                <div class="mt-6 text-center">
                                    <button class="mb-1 mr-1 rounded bg-gray-900 px-6 py-3 text-sm font-bold uppercase text-white shadow outline-none hover:shadow-lg focus:outline-none active:bg-gray-700" type="button" style="transition: all 0.15s ease 0s;">
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="relative bg-gray-300 pb-6 pt-8">
        <div class="pointer-events-none absolute bottom-auto left-0 right-0 top-0 -mt-20 w-full overflow-hidden" style="height: 80px;">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="fill-current text-gray-300" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap">
                <div class="w-full px-4 lg:w-6/12">
                    <h4 class="text-3xl font-semibold">Let's keep in touch!</h4>
                    <h5 class="mb-2 mt-0 text-lg text-gray-700">
                        Find us on any of these platforms, we respond 1-2 business days.
                    </h5>
                    <div class="mt-6">
                        <button class="align-center mr-2 h-10 w-10 items-center justify-center rounded-full bg-white p-3 font-normal text-blue-400 shadow-lg outline-none focus:outline-none" type="button">
                            <i class="fab fa-twitter flex"></i></button><button class="align-center mr-2 h-10 w-10 items-center justify-center rounded-full bg-white p-3 font-normal text-blue-600 shadow-lg outline-none focus:outline-none" type="button">
                            <i class="fab fa-facebook-square flex"></i></button><button class="align-center mr-2 h-10 w-10 items-center justify-center rounded-full bg-white p-3 font-normal text-pink-400 shadow-lg outline-none focus:outline-none" type="button">
                            <i class="fab fa-dribbble flex"></i></button><button class="align-center mr-2 h-10 w-10 items-center justify-center rounded-full bg-white p-3 font-normal text-gray-900 shadow-lg outline-none focus:outline-none" type="button">
                            <i class="fab fa-github flex"></i>
                        </button>
                    </div>
                </div>
                <div class="w-full px-4 lg:w-6/12">
                    <div class="items-top mb-6 flex flex-wrap">
                        <div class="ml-auto w-full px-4 lg:w-4/12">
                            <span class="mb-2 block text-sm font-semibold uppercase text-gray-600">Useful Links</span>
                            <ul class="list-unstyled">
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://www.creative-tim.com/presentation">About Us</a>
                                </li>
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://blog.creative-tim.com">Blog</a>
                                </li>
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://www.github.com/creativetimofficial">Github</a>
                                </li>
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://www.creative-tim.com/bootstrap-themes/free">Free Products</a>
                                </li>
                            </ul>
                        </div>
                        <div class="w-full px-4 lg:w-4/12">
                            <span class="mb-2 block text-sm font-semibold uppercase text-gray-600">Other Resources</span>
                            <ul class="list-unstyled">
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://github.com/creativetimofficial/argon-design-system/blob/master/LICENSE.md">MIT License</a>
                                </li>
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://creative-tim.com/terms">Terms &amp; Conditions</a>
                                </li>
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://creative-tim.com/privacy">Privacy Policy</a>
                                </li>
                                <li>
                                    <a class="block pb-2 text-sm font-semibold text-gray-700 hover:text-gray-900" href="https://creative-tim.com/contact-us">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-400" />
            <div class="flex flex-wrap items-center justify-center md:justify-between">
                <div class="mx-auto w-full px-4 text-center md:w-4/12">
                    <div class="py-1 text-sm font-semibold text-gray-600">
                        Copyright © @php echo date('Y') @endphp nama Toko anda
                        <a href="https://www.creative-tim.com" class="text-gray-600 hover:text-gray-900">- Pengelola Toko</a>.
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
