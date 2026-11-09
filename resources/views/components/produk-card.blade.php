@props(['produk'])

<a href="{{ route('katalog.show', $produk) }}" class="product-card reveal">
    <div class="product-card__media">
        <img src="{{ $produk->fotoUrl() }}" alt="{{ $produk->nama }}" loading="lazy">
        <span class="product-card__cat">{{ $produk->kategori->nama }}</span>
    </div>
    <div class="product-card__body">
        <h3 class="product-card__name">{{ $produk->nama }}</h3>
        <span class="product-card__price">{{ $produk->rupiah() }}</span>
        <div class="product-card__meta">
            <span class="product-card__seller">
                <x-icon name="store" :size="14" /> {{ $produk->user->name }}
            </span>
            @if ($produk->stok <= 0)
                <span class="xsmall muted">Stok habis</span>
            @endif
        </div>
    </div>
</a>
