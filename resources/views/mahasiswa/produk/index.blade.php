@extends('layouts.app')

@section('title', 'Produk Saya')
@section('topbar_title', 'Produk Saya')
@section('sidebar')@include('partials.sidebar-mahasiswa')@endsection

@section('content')
    <div class="page-head page-head--row">
        <div>
            <h1 class="page-head__title">Produk Saya</h1>
            <p class="page-head__desc">Kelola seluruh produk etalase kamu, pantau status verifikasi dan alasan penolakan.</p>
        </div>
        <a href="{{ route('mahasiswa.produk.create') }}" class="btn"><x-icon name="plus" :size="16" /> Tambah Produk</a>
    </div>

    <div class="chip-row mb-md">
        <a href="{{ route('mahasiswa.produk.index') }}" class="chip {{ $status ? '' : 'is-active' }}">Semua <span class="chip__count">{{ $ringkasan['total'] }}</span></a>
        <a href="{{ route('mahasiswa.produk.index', ['status' => 'disetujui']) }}" class="chip {{ $status==='disetujui' ? 'is-active' : '' }}">Disetujui <span class="chip__count">{{ $ringkasan['disetujui'] }}</span></a>
        <a href="{{ route('mahasiswa.produk.index', ['status' => 'menunggu']) }}" class="chip {{ $status==='menunggu' ? 'is-active' : '' }}">Menunggu <span class="chip__count">{{ $ringkasan['menunggu'] }}</span></a>
        <a href="{{ route('mahasiswa.produk.index', ['status' => 'ditolak']) }}" class="chip {{ $status==='ditolak' ? 'is-active' : '' }}">Ditolak <span class="chip__count">{{ $ringkasan['ditolak'] }}</span></a>
    </div>

    @if ($produk->isEmpty())
        <div class="empty panel">
            <div class="empty__icon"><x-icon name="box" :size="24" /></div>
            <h3 class="empty__title">Belum ada produk</h3>
            <p class="empty__desc">Mulai unggah produk pertamamu. Admin akan memverifikasi sebelum tayang di katalog.</p>
            <a href="{{ route('mahasiswa.produk.create') }}" class="btn mt-sm"><x-icon name="plus" :size="16" /> Tambah Produk</a>
        </div>
    @else
        <div class="panel"><div class="table-wrap">
            <table class="table">
                <thead><tr>
                    <th>Produk</th><th>Harga</th><th>Stok</th><th>Status</th><th class="text-right">Aksi</th>
                </tr></thead>
                <tbody>
                    @foreach ($produk as $p)
                        <tr>
                            <td>
                                <div class="table__product">
                                    <div class="table__thumb"><img src="{{ $p->fotoUrl() }}" alt=""></div>
                                    <div>
                                        <div class="table__name">{{ $p->nama }}</div>
                                        <div class="table__sub">{{ $p->kategori->nama }}</div>
                                        @if ($p->isDitolak() && $p->alasan_penolakan)
                                            <div class="table__sub" style="color:var(--danger)">{{ Str::limit($p->alasan_penolakan, 48) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="nowrap strong">{{ $p->rupiah() }}</td>
                            <td>{{ $p->stok }}</td>
                            <td><x-status-badge :status="$p->status" /></td>
                            <td>
                                <div class="table__actions">
                                    <a href="{{ route('mahasiswa.produk.show', $p) }}" class="btn btn-ghost btn-sm" title="Lihat"><x-icon name="search" :size="15" /></a>
                                    <a href="{{ route('mahasiswa.produk.edit', $p) }}" class="btn btn-outline btn-sm" title="Edit"><x-icon name="edit" :size="15" /></a>
                                    <form method="POST" action="{{ route('mahasiswa.produk.destroy', $p) }}" data-confirm="Hapus produk ini? Tindakan tidak dapat dibatalkan.">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-sm" title="Hapus" style="color:var(--danger)"><x-icon name="trash" :size="15" /></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div></div>
        {{ $produk->links('components.pagination') }}
    @endif
@endsection
