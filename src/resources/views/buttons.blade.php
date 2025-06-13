@if($menu->getNumMenuItems())
    <div class="buttons mb-3">
        @foreach($menu->getMenuItems() as $item)
            @if(!$item->isActive())
                <a href="{{ $item->getHref() }}" class="btn btn-secondary">
                <i class=" bi bi-{{ $item->getIcon() }}"></i> {{ $item->getLabel() }}</a>
            @endif
        @endforeach
    </div>
@endif