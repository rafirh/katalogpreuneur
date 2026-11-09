@extends('layouts.app')

@section('title', 'Tinjau Produk')
@section('topbar_title', 'Tinjau Produk')
@section('sidebar')@include('partials.sidebar-admin')@endsection

@section('content')
    <div class="content-narrow">
        <a href="{{ route('admin.verifikasi.index') }}" class="small strong row gap-xs items-center" style="color:var(--forest-700);margin-bottom:1rem"><x-icon name="chevron-left" :size="16" /> Kembali</a>

        <div class="detail__grid" style="grid-template-columns:0.9fr 1.1fr">
            <div class="detail__media">
                @if($u=$produk->fotoUrl())<img src="{{ $u }}" alt="{{ $produk->nama }}">@else<div class="product-thumb-placeholder" style="font-size:3rem">{{ mb_substr($produk->nama,0,1) }}</div>@endif
            </div>
            <div>
                <div class="row between items-center wrap gap-sm mb-sm">
                    <span class="detail__cat">{{ $produk->kategori->nama }}</span>
                    <x-status-badge :status="$produk->status" lg />
                </div>
                <h1 class="detail__title" style="font-size:1.7rem">{{ $produk->nama }}</h1>
                <div class="detail__price" style="font-size:1.5rem">{{ $produk->rupiah() }}</div>

                <div class="detail__seller" style="margin-top:1.25rem">
                    <span class="avatar">{{ $produk->user->inisial() }}</span>
                    <div><div class="detail__seller-name">{{ $produk->user->name }}</div><div class="detail__seller-sub">{{ $produk->user->email }}{{ $produk->user->whatsapp_number ? ' · '.$produk->user->whatsapp_number : '' }}</div></div>
                </div>

                <div class="detail-info-grid">
                    <div><div class="k">Stok</div><div class="v">{{ $produk->stok }}</div></div>
                    <div><div class="k">Diajukan</div><div class="v">{{ $produk->created_at->format('d M Y') }}</div></div>
                    <div><div class="k">Kategori</div><div class="v">{{ $produk->kategori->nama }}</div></div>
                </div>

                <p class="detail__desc">{{ $produk->deskripsi }}</p>

                @if ($produk->isDitolak() && $produk->alasan_penolakan)
                    <div class="reject-note mt-md"><strong>Alasan penolakan saat ini</strong>{{ $produk->alasan_penolakan }}</div>
                @endif

                <div class="form-actions" style="justify-content:flex-start">
                    @if ($produk->status !== 'disetujui')
                        <form method="POST" action="{{ route('admin.verifikasi.approve', $produk) }}">@csrf @method('PATCH')
                            <button type="submit" class="btn" style="background:var(--success);border-color:var(--success)"><x-icon name="check" :size="16" /> Setujui Produk</button>
                        </form>
                    @endif
                    @if ($produk->status !== 'ditolak')
                        <button type="button" class="btn btn-outline" style="color:var(--danger);border-color:#eccfcb" data-modal-open="#reject-show">Tolak Produk</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="reject-show">
        <div class="modal">
            <form method="POST" action="{{ route('admin.verifikasi.reject', $produk) }}">
                @csrf @method('PATCH')
                <div class="modal__head">
                    <div><h3 class="modal__title">Tolak produk</h3><p class="small muted mt-sm">{{ $produk->nama }}</p></div>
                    <button type="button" class="modal__close" data-modal-close><x-icon name="x" :size="16"/></button>
                </div>
                <div class="modal__body">
                    <div class="field">
                        <label class="label" for="alasan">Alasan penolakan <span class="req">*</span></label>
                        <textarea id="alasan" name="alasan_penolakan" class="textarea" style="min-height:110px" placeholder="Jelaskan alasan agar penjual dapat memperbaiki (min. 5 karakter)." required></textarea>
                    </div>
                </div>
                <div class="modal__foot">
                    <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak Produk</button>
                </div>
            </form>
        </div>
    </div>
@endsection
