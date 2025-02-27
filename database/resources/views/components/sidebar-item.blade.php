<li class="sidebar-item">
    <a href="{{ $href }}" class="sidebar-link">
        <img src="{{ asset('images/' . $icon . '.svg') }}" alt="{{ $title }} Icon" class="icon">
        <span>{{ $title }}</span>
    </a>
    @if ($submenu)
        <ul class="submenu">
            @foreach ($submenu as $subItem)
                <li><a href="{{ $subItem['href'] }}">{{ $subItem['title'] }}</a></li>
            @endforeach
        </ul>
    @endif
</li>