@extends('layouts.app')

@section('title', 'Ringkasan')
@section('topbar_title', 'Ringkasan')
@section('sidebar')@include('partials.sidebar-mahasiswa')@endsection

@section('content')
    <div class="page-head">
        <h1 class="page-head__title">Halo, {{ Str::before(auth()->user()->name, ' ') }}.</h1>
        <p class="page-head__desc">Berikut ringkasan etalase produkmu di KatalogPreneur UB.</p>
    </div>

    <div class="stat-grid">
        <div class="stat stat--neutral"><span class="stat__accent"></span><span class="stat__label">Total Produk</span><span class="stat__value">{{ $ringkasan['total'] }}</span></div>
        <div class="stat stat--disetujui"><span class="stat__accent"></span><span class="stat__label">Disetujui</span><span class="stat__value">{{ $ringkasan['disetujui'] }}</span></div>
        <div class="stat stat--menunggu"><span class="stat__accent"></span><span class="stat__label">Menunggu</span><span class="stat__value">{{ $ringkasan['menunggu'] }}</span></div>
        <div class="stat stat--ditolak"><span class="stat__accent"></span><span class="stat__label">Ditolak</span><span class="stat__value">{{ $ringkasan['ditolak'] }}</span></div>
    </div>

    <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.25rem;align-items:start" class="dash-cols">
        <div class="panel">
            <div class="panel__head">
                <span class="panel__title">Produk terbaru</span>
                <a href="{{ route('mahasiswa.produk.index') }}" class="small strong" style="color:var(--forest-700)">Kelola semua</a>
            </div>
            @if ($terbaru->isEmpty())
                <div class="empty">
                    <div class="empty__icon"><x-icon name="box" :size="24" /></div>
                    <h3 class="empty__title">Belum ada produk</h3>
                    <p class="empty__desc">Unggah produk pertamamu dan mulai jualan di katalog kampus.</p>
                    <a href="{{ route('mahasiswa.produk.create') }}" class="btn btn-sm mt-sm"><x-icon name="plus" :size="16" /> Tambah Produk</a>
                </div>
            @else
                <div class="table-wrap"><table class="table">
                    <tbody>
                        @foreach ($terbaru as $p)
                            <tr>
                                <td>
                                    <div class="table__product">
                                        <div class="table__thumb"><img src="{{ $p->fotoUrl() }}" alt=""></div>
                                        <div><div class="table__name">{{ $p->nama }}</div><div class="table__sub">{{ $p->kategori->nama }} · {{ $p->rupiah() }}</div></div>
                                    </div>
                                </td>
                                <td class="text-right"><x-status-badge :status="$p->status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
            @endif
        </div>

        <div class="stack gap-md">
            <a href="{{ route('mahasiswa.produk.create') }}" class="panel" style="background:var(--forest-800);border-color:var(--forest-800);color:#fff">
                <div class="panel__body">
                    <x-icon name="plus" :size="24" />
                    <div class="strong mt-sm" style="font-size:1.1rem">Tambah produk baru</div>
                    <div class="small" style="color:#b9cabb;margin-top:2px">Unggah produk dan tunggu verifikasi admin.</div>
                </div>
            </a>

            @if ($ditolak->isNotEmpty())
                <div class="panel">
                    <div class="panel__head"><span class="panel__title">Perlu diperbaiki</span></div>
                    <div class="panel__body stack gap-sm">
                        @foreach ($ditolak as $p)
                            <div class="reject-note">
                                <strong>{{ $p->nama }}</strong>
                                {{ $p->alasan_penolakan }}
                                <div class="mt-sm"><a href="{{ route('mahasiswa.produk.edit', $p) }}" class="small strong" style="color:var(--danger)">Perbaiki produk</a></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="panel"><div class="panel__body">
                    <div class="row gap-sm items-center" style="color:var(--forest-700)"><x-icon name="check-circle" :size="18" /><span class="strong">Semua berjalan baik</span></div>
                    <p class="small muted mt-sm">Tidak ada produk yang perlu diperbaiki saat ini.</p>
                </div></div>
            @endif
        </div>
    </div>

    <style>@media(max-width:900px){.dash-cols{grid-template-columns:1fr !important}}</style>
@endsection
