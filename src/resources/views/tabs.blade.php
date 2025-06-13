@if($menu->getNumMenuItems())
    <ul class="nav nav-tabs justify-content-end mb-3">
        @foreach($menu->getMenuItems() as $item)
            <li class="nav-item">
                <a href="{{ $item->getHref() }}" class="nav-link @if($item->isActive()) active @endif">
                    <i class="bi bi-{{ $item->getIcon() }}"></i> {{ $item->getLabel() }}</a>
            </li>
        @endforeach
    </ul>
@endif
