@extends('layouts.app')

@section('title', 'Data Penjual')
@section('topbar_title', 'Data Penjual')
@section('sidebar')@include('partials.sidebar-admin')@endsection

@section('content')
    <div class="page-head page-head--row">
        <div>
            <h1 class="page-head__title">Data Penjual</h1>
            <p class="page-head__desc">Daftar mahasiswa penjual terdaftar di KatalogPreneur UB.</p>
        </div>
        <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="search-box" style="max-width:280px">
            <x-icon name="search" :size="17"/><input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau email...">
        </form>
    </div>

    @if ($mahasiswa->isEmpty())
        <div class="empty panel"><div class="empty__icon"><x-icon name="users" :size="24"/></div><h3 class="empty__title">Belum ada penjual</h3><p class="empty__desc">Belum ada mahasiswa yang mendaftar sebagai penjual.</p></div>
    @else
        <div class="panel"><div class="table-wrap">
            <table class="table">
                <thead><tr><th>Penjual</th><th>Email</th><th>WhatsApp</th><th>Produk</th><th>Tayang</th><th>Terdaftar</th></tr></thead>
                <tbody>
                    @foreach ($mahasiswa as $m)
                        <tr>
                            <td><div class="table__product"><span class="avatar">{{ $m->inisial() }}</span><div class="table__name">{{ $m->name }}</div></div></td>
                            <td class="small muted">{{ $m->email }}</td>
                            <td class="small">{{ $m->whatsapp_number ?: '—' }}</td>
                            <td>{{ $m->produk_count }}</td>
                            <td><span class="badge badge-disetujui">{{ $m->produk_disetujui_count }}</span></td>
                            <td class="small muted nowrap">{{ $m->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div></div>
        {{ $mahasiswa->links('components.pagination') }}
    @endif
@endsection
