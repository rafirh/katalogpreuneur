@extends('layouts.public')

@section('title', 'Jelajahi Produk — KatalogPreneur UB')

@section('content')
    <section class="katalog-head">
        <div class="container">
            <span class="eyebrow">Katalog Publik</span>
            <h1 class="katalog-title mt-sm">{{ $kategoriAktif ? $kategoriAktif->nama : 'Jelajahi Produk' }}</h1>
            <p class="lead mt-sm" style="max-width:60ch">{{ $kategoriAktif?->deskripsi ?? 'Temukan produk kreatif dari mahasiswa Universitas Brawijaya, siap dipesan langsung melalui WhatsApp.' }}</p>
        </div>
    </section>

    <div class="container">
        <form method="GET" action="{{ route('katalog.index') }}" class="katalog-toolbar">
            <div class="search-box">
                <x-icon name="search" :size="18" />
                <input type="text" name="q" value="{{ $q }}" placeholder="Cari produk, penjual, atau kata kunci..." aria-label="Cari produk">
            </div>
            @if ($kategoriAktif)
                <input type="hidden" name="kategori" value="{{ $kategoriAktif->slug }}">
            @endif
            <select name="urut" class="select" style="width:auto" aria-label="Urutkan" onchange="this.form.submit()">
                <option value="terbaru" @selected($urut === 'terbaru')>Terbaru</option>
                <option value="termurah" @selected($urut === 'termurah')>Harga terendah</option>
                <option value="termahal" @selected($urut === 'termahal')>Harga tertinggi</option>
            </select>
            <button type="submit" class="btn">Cari</button>
        </form>

        <div class="chip-row mb-lg">
            <a href="{{ route('katalog.index', array_filter(['q' => $q ?: null])) }}" class="chip {{ ! $kategoriAktif ? 'is-active' : '' }}">Semua</a>
            @foreach ($kategori as $k)
                <a href="{{ route('katalog.index', array_filter(['kategori' => $k->slug, 'q' => $q ?: null])) }}" class="chip {{ $kategoriAktif?->id === $k->id ? 'is-active' : '' }}">
                    {{ $k->nama }} <span class="chip__count">{{ $k->produk_disetujui_count }}</span>
                </a>
            @endforeach
        </div>

        <div class="row between items-center mb-md">
            <span class="katalog-result-count">{{ number_format($total) }} produk ditemukan @if ($q) untuk "{{ $q }}" @endif</span>
        </div>

        @if ($produk->isEmpty())
            <div class="empty panel">
                <div class="empty__icon"><x-icon name="search" :size="24" /></div>
                <h3 class="empty__title">Tidak ada produk yang cocok</h3>
                <p class="empty__desc">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-outline btn-sm mt-sm">Reset filter</a>
            </div>
        @else
            <div class="product-grid">
                @foreach ($produk as $item)
                    <x-produk-card :produk="$item" />
                @endforeach
            </div>

            {{ $produk->links('components.pagination') }}
        @endif
    </div>
@endsection
