@props([
    'title' => 'Menu',
    'icon' => 'settings',
    'type' => 'links', 
    'items' => []     
])

<div {{ $attributes->merge(['class' => 'card shadow-none border mb-3']) }}>
    <div class="card-header pb-0 p-3 bg-transparent">
        <h6 class="mb-0 text-sm font-weight-bolder text-dark">
            <i class="material-symbols-rounded text-sm me-2">{{ $icon }}</i>{{ $title }}
        </h6>
    </div>

    @if($type === 'form')
        <div class="card-body p-3">
            {{ $slot }}
        </div>
    @else
        <div class="card-body p-2">
            <div class="nav nav-pills flex-column">
                @foreach($items as $item)
                    @if(isset($item['divider']) && $item['divider'])
                        <hr class="horizontal dark my-2">
                    @else
                        <a class="nav-link d-flex align-items-center py-2 px-3 border-radius-md mb-1 {{ $item['class'] ?? 'text-dark' }} sidebar-link" 
                        href="{{ $item['route'] }}" 
                        style="font-size: 13px; transition: all 0.2s; font-weight: 500;">
                            
                            <i class="material-symbols-rounded text-sm me-3 {{ $item['icon_class'] ?? 'text-primary' }}">
                                {{ $item['icon'] ?? 'circle' }}
                            </i>
                            
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
                
                {{ $slot }}
            </div>
        </div>

        <style>
            .sidebar-link:hover {
                background-color: rgba(26, 32, 53, 0.05); 
                color: #1a73e8 !important; 
                transform: translateX(4px);
            }
            
            .sidebar-link.active {
                background-image: linear-gradient(195deg, #42424a 0%, #191919 100%);
                color: #fff !important;
            }

            .sidebar-link.active i {
                color: #fff !important;
            }
        </style>
    @endif
</div>