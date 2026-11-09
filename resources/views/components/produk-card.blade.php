@props(['produk'])

<a href="{{ route('katalog.show', $produk) }}" class="product-card reveal">
    <div class="product-card__media">
        @if ($url = $produk->fotoUrl())
            <img src="{{ $url }}" alt="{{ $produk->nama }}" loading="lazy">
        @else
            <div class="product-thumb-placeholder">{{ mb_substr($produk->nama, 0, 1) }}</div>
        @endif
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
