@extends('layouts.public')

@section('title', $produk->nama . ' — KatalogPreneur UB')
@section('meta_description', Str::limit(strip_tags($produk->deskripsi), 150))

@section('content')
    <div class="detail">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('katalog.index') }}">Katalog</a>
                <span>/</span>
                <a href="{{ route('katalog.index', ['kategori' => $produk->kategori->slug]) }}">{{ $produk->kategori->nama }}</a>
                <span>/</span>
                <span style="color:var(--ink)">{{ Str::limit($produk->nama, 40) }}</span>
            </nav>

            <div class="detail__grid">
                <div class="detail__media reveal">
                    @if ($url = $produk->fotoUrl())
                        <img src="{{ $url }}" alt="{{ $produk->nama }}">
                    @else
                        <div class="product-thumb-placeholder" style="font-size:4rem">{{ mb_substr($produk->nama, 0, 1) }}</div>
                    @endif
                </div>

                <div class="reveal reveal-1">
                    <span class="detail__cat">{{ $produk->kategori->nama }}</span>
                    <h1 class="detail__title">{{ $produk->nama }}</h1>
                    <div class="detail__price">{{ $produk->rupiah() }}</div>
                    <div class="detail__stock">
                        <x-icon name="box" :size="16" />
                        @if ($produk->stok > 0)
                            Stok tersedia: {{ $produk->stok }} unit
                        @else
                            Stok habis
                        @endif
                    </div>

                    <p class="detail__desc">{{ $produk->deskripsi }}</p>

                    <div class="detail__seller">
                        <span class="avatar avatar-lg">{{ $produk->user->inisial() }}</span>
                        <div>
                            <div class="detail__seller-name">{{ $produk->user->name }}</div>
                            <div class="detail__seller-sub">Penjual mahasiswa UB</div>
                        </div>
                    </div>

                    <div class="detail__actions">
                        @if ($waUrl = $produk->whatsappOrderUrl())
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-amber btn-lg btn-block">
                                <x-icon name="whatsapp" :size="18" /> Pesan via WhatsApp
                            </a>
                        @else
                            <button class="btn btn-lg btn-block is-disabled" disabled>Nomor WhatsApp belum tersedia</button>
                        @endif
                        <p class="detail__note">Transaksi dilakukan langsung dengan penjual. Sebutkan nama produk saat menghubungi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($terkait->isNotEmpty())
        <section class="section--tight">
            <div class="container">
                <div class="section-divider">
                    <h2 class="section-title">Produk serupa</h2>
                    <a href="{{ route('katalog.index', ['kategori' => $produk->kategori->slug]) }}" class="small strong" style="color:var(--forest-700)">Lihat kategori</a>
                </div>
                <div class="product-grid">
                    @foreach ($terkait as $item)
                        <x-produk-card :produk="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
