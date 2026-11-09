@props(['sub' => true])

<a href="{{ route('home') }}" class="brand">
    <span class="brand__mark">
        <x-icon name="store" :size="19" :stroke="2" />
    </span>
    <span class="brand__text">
        <span>KatalogPreneur</span>
        @if ($sub)
            <span class="brand__sub">Universitas Brawijaya</span>
        @endif
    </span>
</a>
