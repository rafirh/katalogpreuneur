@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('topbar_title', 'Ringkasan Admin')
@section('sidebar')@include('partials.sidebar-admin')@endsection

@section('content')
    <div class="page-head page-head--row">
        <div>
            <h1 class="page-head__title">Ringkasan Admin</h1>
            <p class="page-head__desc">Pantau aktivitas katalog dan verifikasi produk mahasiswa.</p>
        </div>
        <a href="{{ route('admin.verifikasi.index') }}" class="btn"><x-icon name="check-circle" :size="16" /> Verifikasi antrean</a>
    </div>

    <div class="stat-grid stat-grid--5">
        <div class="stat stat--neutral"><span class="stat__accent"></span><span class="stat__label">Penjual</span><span class="stat__value">{{ $statistik['users'] }}</span></div>
        <div class="stat stat--neutral"><span class="stat__accent"></span><span class="stat__label">Total Produk</span><span class="stat__value">{{ $statistik['total'] }}</span></div>
        <div class="stat stat--menunggu"><span class="stat__accent"></span><span class="stat__label">Menunggu</span><span class="stat__value">{{ $statistik['menunggu'] }}</span></div>
        <div class="stat stat--disetujui"><span class="stat__accent"></span><span class="stat__label">Disetujui</span><span class="stat__value">{{ $statistik['disetujui'] }}</span></div>
        <div class="stat stat--ditolak"><span class="stat__accent"></span><span class="stat__label">Ditolak</span><span class="stat__value">{{ $statistik['ditolak'] }}</span></div>
    </div>

    <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:1.25rem;align-items:start" class="dash-cols">
        <div class="panel">
            <div class="panel__head">
                <span class="panel__title">Antrean verifikasi</span>
                <a href="{{ route('admin.verifikasi.index') }}" class="small strong" style="color:var(--forest-700)">Lihat semua</a>
            </div>
            @if ($antrean->isEmpty())
                <div class="empty">
                    <div class="empty__icon" style="color:var(--success);background:var(--success-soft)"><x-icon name="check-circle" :size="24" /></div>
                    <h3 class="empty__title">Antrean kosong</h3>
                    <p class="empty__desc">Semua produk telah ditinjau. Kerja bagus!</p>
                </div>
            @else
                <div class="table-wrap"><table class="table"><tbody>
                    @foreach ($antrean as $p)
                        <tr>
                            <td>
                                <div class="table__product">
                                    <div class="table__thumb">@if($u=$p->fotoUrl())<img src="{{ $u }}" alt="">@else<span class="product-thumb-placeholder" style="font-size:1rem">{{ mb_substr($p->nama,0,1) }}</span>@endif</div>
                                    <div><div class="table__name">{{ $p->nama }}</div><div class="table__sub">{{ $p->user->name }} · {{ $p->kategori->nama }}</div></div>
                                </div>
                            </td>
                            <td class="text-right"><a href="{{ route('admin.verifikasi.show', $p) }}" class="btn btn-outline btn-sm">Tinjau</a></td>
                        </tr>
                    @endforeach
                </tbody></table></div>
            @endif
        </div>

        <div class="panel">
            <div class="panel__head"><span class="panel__title">Produk per kategori</span></div>
            <div class="panel__body stack gap-sm">
                @foreach ($perKategori as $k)
                    <div>
                        <div class="row between small"><span class="strong">{{ $k->nama }}</span><span class="muted">{{ $k->produk_disetujui_count }}/{{ $k->produk_count }} tayang</span></div>
                        <div style="height:6px;border-radius:3px;background:var(--sage-50);margin-top:6px;overflow:hidden">
                            <div style="height:100%;width:{{ $k->produk_count ? round($k->produk_disetujui_count / max($k->produk_count,1) * 100) : 0 }}%;background:var(--forest-600)"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>@media(max-width:900px){.dash-cols{grid-template-columns:1fr !important}}</style>
@endsection
