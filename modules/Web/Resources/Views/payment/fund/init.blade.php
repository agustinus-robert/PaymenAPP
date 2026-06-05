@extends('web::payment.index')

@section('title', "Beranda")

@section('content')
    @if(isset($sections[0]))
        <section class="w-100">
            @includeIf($sections[0]['view'], $sections[0]['data'])
        </section>
    @endif

    <div class="container-xl py-5">

        <div class="d-flex flex-column">
            @foreach($sections as $section)
                @if($section['order'] > 1)
                    <div class="bg-body-secondary p-4 rounded-3 border border-secondary border-opacity-10">
                        @includeIf($section['view'], $section['data'])
                    </div>
                @endif
            @endforeach
        </div>

    </div>

    @include('web::payment.fund.vue-js')
@endsection
