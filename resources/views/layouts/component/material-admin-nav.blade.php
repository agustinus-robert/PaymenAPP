<style>
    .rotate-icon {
        transition: transform .25s ease;
    }
    .nav-link[aria-expanded="true"] .rotate-icon {
        transform: rotate(180deg);
    }

    #sidenav-main .nav-link[data-bs-toggle="collapse"]::after {
        content: none !important;
    }
</style>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-xl-none" id="iconSidenav"></i>

        <a class="navbar-brand px-4 py-3 m-0" href="#">
            {{-- <img src="/assets/img/logo.png" class="navbar-brand-img" width="26" height="26"> --}}
            <span class="ms-1 text-sm text-dark">Solo CMS</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            @foreach($menus as $item)

                {{-- ---------------- TITLE ---------------- --}}
                @if($item['type'] === 'title')
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
                            {{ $item['label'] }}
                        </h6>
                    </li>
                    @continue
                @endif

                {{-- ---------------- SINGLE ITEM ---------------- --}}
                @if($item['type'] === 'item')
                    @php
                        $active = request()->url() === $item['route']
                            ? 'active bg-gradient-dark text-white'
                            : 'text-dark';
                    @endphp

                    <li class="nav-item">
                        <a class="nav-link {{ $active }}" href="{{ $item['route'] }}">
                            <i class="material-symbols-rounded opacity-5">{{ $item['icon'] }}</i>
                            <span class="nav-link-text ms-1">{{ $item['label'] }}</span>
                        </a>
                    </li>

                    @continue
                @endif

                @if($item['type'] === 'dropdown')

                    @php
                        $childActive = collect($item['children'])->contains(function($child) {
                            return request()->url() === $child['route'];
                        });

                        $dropdownActive = $childActive ? 'active bg-gradient-dark text-white' : 'text-dark';
                        $showChildren   = $childActive ? 'show' : '';
                    @endphp

                    <li class="nav-item">

                        <a class="nav-link d-flex align-items-center {{ $dropdownActive }}"
                        data-bs-toggle="collapse"
                        href="#menu-{{ Str::slug($item['label']) }}"
                        role="button"
                        aria-expanded="{{ $childActive ? 'true' : 'false' }}">

                            {{-- ICON --}}
                            <i class="material-symbols-rounded opacity-5 me-2">
                                {{ $item['icon'] }}
                            </i>

                            {{-- LABEL --}}
                            <span class="nav-link-text flex-grow-1 ms-1">
                                {{ $item['label'] }}
                            </span>

                            {{-- CHEVRON --}}
                            <i class="material-symbols-rounded rotate-icon ms-auto">
                                expand_more
                            </i>
                        </a>

                        <div class="collapse {{ $showChildren }}" id="menu-{{ Str::slug($item['label']) }}">
                            <ul class="nav ms-4">

                                @foreach($item['children'] as $child)
                                    @php
                                        $childIsActive = request()->url() === $child['route']
                                            ? 'active text-dark fw-bold'
                                            : 'text-dark';
                                    @endphp

                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center {{ $childIsActive }}"
                                        href="{{ $child['route'] }}">

                                            <i class="material-symbols-rounded opacity-5 me-2">
                                                {{ $child['icon'] }}
                                            </i>

                                            <span class="nav-link-text ms-1">
                                                {{ $child['label'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                    </li>

                @endif

            @endforeach

        </ul>
    </div>

</aside>
