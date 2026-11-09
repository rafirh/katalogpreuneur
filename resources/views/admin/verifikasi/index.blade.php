@extends('layouts.app')

@section('title', 'Verifikasi Produk')
@section('topbar_title', 'Verifikasi Produk')
@section('sidebar')@include('partials.sidebar-admin')@endsection

@section('content')
    <div class="page-head">
        <h1 class="page-head__title">Verifikasi Produk</h1>
        <p class="page-head__desc">Tinjau produk mahasiswa. Setujui untuk tayang di katalog, atau tolak dengan alasan yang jelas.</p>
    </div>

    <div class="row between items-center wrap gap-md mb-md">
        <div class="chip-row">
            <a href="{{ route('admin.verifikasi.index', ['status' => 'menunggu']) }}" class="chip {{ $status==='menunggu' ? 'is-active' : '' }}">Menunggu <span class="chip__count">{{ $hitung['menunggu'] }}</span></a>
            <a href="{{ route('admin.verifikasi.index', ['status' => 'disetujui']) }}" class="chip {{ $status==='disetujui' ? 'is-active' : '' }}">Disetujui <span class="chip__count">{{ $hitung['disetujui'] }}</span></a>
            <a href="{{ route('admin.verifikasi.index', ['status' => 'ditolak']) }}" class="chip {{ $status==='ditolak' ? 'is-active' : '' }}">Ditolak <span class="chip__count">{{ $hitung['ditolak'] }}</span></a>
        </div>
        <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="row gap-sm items-center">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="search-box"><x-icon name="search" :size="17"/><input type="text" name="q" value="{{ $q }}" placeholder="Cari produk atau penjual..." style="padding-block:0.55rem"></div>
        </form>
    </div>

    @if ($produk->isEmpty())
        <div class="empty panel">
            <div class="empty__icon"><x-icon name="check-circle" :size="24" /></div>
            <h3 class="empty__title">Tidak ada produk</h3>
            <p class="empty__desc">Belum ada produk pada status ini.</p>
        </div>
    @else
        <div class="product-grid" style="grid-template-columns:repeat(3,1fr)">
            @foreach ($produk as $p)
                <div class="panel" style="display:flex;flex-direction:column">
                    <div style="aspect-ratio:16/10;overflow:hidden;border-bottom:1px solid var(--border);background:var(--sage-50)">
                        <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" style="width:100%;height:100%;object-fit:cover">
                    </div>
                    <div class="panel__body" style="flex:1;display:flex;flex-direction:column;gap:0.35rem">
                        <div class="row between items-center"><span class="xsmall muted">{{ $p->kategori->nama }}</span><x-status-badge :status="$p->status" /></div>
                        <div class="strong" style="font-size:1.02rem;line-height:1.25">{{ $p->nama }}</div>
                        <div class="small muted">{{ $p->user->name }}</div>
                        <div class="strong" style="color:var(--forest-800);margin-top:auto;padding-top:0.5rem">{{ $p->rupiah() }}</div>
                    </div>
                    <div class="panel__body" style="padding-top:0;display:flex;gap:0.5rem;flex-wrap:wrap">
                        <a href="{{ route('admin.verifikasi.show', $p) }}" class="btn btn-outline btn-sm" style="flex:1">Tinjau</a>
                        @if ($p->status !== 'disetujui')
                            <form method="POST" action="{{ route('admin.verifikasi.approve', $p) }}" style="flex:1">@csrf @method('PATCH')<button type="submit" class="btn btn-sm btn-block" style="background:var(--success);border-color:var(--success)">Setujui</button></form>
                        @endif
                        @if ($p->status !== 'ditolak')
                            <button type="button" class="btn btn-outline btn-sm" style="flex:1;color:var(--danger);border-color:#eccfcb" data-modal-open="#reject-{{ $p->id }}">Tolak</button>
                        @endif
                    </div>
                </div>

                <div class="modal-overlay" id="reject-{{ $p->id }}">
                    <div class="modal">
                        <form method="POST" action="{{ route('admin.verifikasi.reject', $p) }}">
                            @csrf @method('PATCH')
                            <div class="modal__head">
                                <div><h3 class="modal__title">Tolak produk</h3><p class="small muted mt-sm">{{ $p->nama }}</p></div>
                                <button type="button" class="modal__close" data-modal-close><x-icon name="x" :size="16"/></button>
                            </div>
                            <div class="modal__body">
                                <div class="field">
                                    <label class="label" for="alasan-{{ $p->id }}">Alasan penolakan <span class="req">*</span></label>
                                    <textarea id="alasan-{{ $p->id }}" name="alasan_penolakan" class="textarea" style="min-height:110px" placeholder="Jelaskan alasan agar penjual dapat memperbaiki produknya (min. 5 karakter)." required></textarea>
                                    <span class="field-hint">Alasan akan ditampilkan kepada penjual.</span>
                                </div>
                            </div>
                            <div class="modal__foot">
                                <button type="button" class="btn btn-outline" data-modal-close>Batal</button>
                                <button type="submit" class="btn btn-danger">Tolak Produk</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $produk->links('components.pagination') }}
    @endif
    <style>@media(max-width:900px){.product-grid{grid-template-columns:repeat(2,1fr) !important}}@media(max-width:560px){.product-grid{grid-template-columns:1fr !important}}</style>
@endsection
