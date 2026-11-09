@extends('layouts.app')

@section('title', $produk->nama)
@section('topbar_title', 'Detail Produk')
@section('sidebar')@include('partials.sidebar-mahasiswa')@endsection

@section('content')
    <div class="content-narrow">
        <a href="{{ route('mahasiswa.produk.index') }}" class="small strong row gap-xs items-center" style="color:var(--forest-700);margin-bottom:1rem"><x-icon name="chevron-left" :size="16" /> Kembali</a>

        <div class="detail__grid" style="grid-template-columns:0.9fr 1.1fr">
            <div class="detail__media">
                @if ($u = $produk->fotoUrl())<img src="{{ $u }}" alt="{{ $produk->nama }}">@else<div class="product-thumb-placeholder" style="font-size:3rem">{{ mb_substr($produk->nama,0,1) }}</div>@endif
            </div>
            <div>
                <div class="row between items-center wrap gap-sm mb-sm">
                    <span class="detail__cat">{{ $produk->kategori->nama }}</span>
                    <x-status-badge :status="$produk->status" lg />
                </div>
                <h1 class="detail__title" style="font-size:1.8rem">{{ $produk->nama }}</h1>
                <div class="detail__price" style="font-size:1.6rem">{{ $produk->rupiah() }}</div>

                @if ($produk->isDitolak() && $produk->alasan_penolakan)
                    <div class="reject-note mt-md"><strong>Alasan penolakan</strong>{{ $produk->alasan_penolakan }}</div>
                @endif

                <div class="detail-info-grid">
                    <div><div class="k">Stok</div><div class="v">{{ $produk->stok }} unit</div></div>
                    <div><div class="k">Status</div><div class="v">{{ $produk->labelStatus() }}</div></div>
                    <div><div class="k">Diperbarui</div><div class="v">{{ $produk->updated_at->format('d M Y') }}</div></div>
                </div>

                <p class="detail__desc">{{ $produk->deskripsi }}</p>

                <div class="form-actions" style="justify-content:flex-start">
                    <a href="{{ route('mahasiswa.produk.edit', $produk) }}" class="btn"><x-icon name="edit" :size="16" /> Edit Produk</a>
                    @if ($produk->isDisetujui())
                        <a href="{{ route('katalog.show', $produk) }}" target="_blank" class="btn btn-outline"><x-icon name="arrow-up-right" :size="16" /> Lihat di Katalog</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
