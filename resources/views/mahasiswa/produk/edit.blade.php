@extends('layouts.app')

@section('title', 'Edit Produk')
@section('topbar_title', 'Edit Produk')
@section('sidebar')@include('partials.sidebar-mahasiswa')@endsection

@section('content')
    <div class="page-head">
        <a href="{{ route('mahasiswa.produk.index') }}" class="small strong row gap-xs items-center" style="color:var(--forest-700);margin-bottom:0.75rem"><x-icon name="chevron-left" :size="16" /> Kembali</a>
        <div class="row gap-sm items-center wrap"><h1 class="page-head__title">Edit Produk</h1><x-status-badge :status="$produk->status" /></div>
        <p class="page-head__desc">Perubahan pada produk yang telah disetujui akan dikembalikan ke status menunggu verifikasi.</p>
    </div>

    @if ($produk->isDitolak() && $produk->alasan_penolakan)
        <div class="reject-note mb-md"><strong>Al        <div class="reject-note mb-md"><strong>Al        <div class="reject-note mb-    <form method="POST" action="{{ route('mahasiswa.produk.update', $produk) }}" enctype="multipart/form-data" data-loading>
        @csrf @method('PUT')
        @include('mahasiswa.produk._form')
    </form>
@endsection
