@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('topbar_title', 'Tambah Produk')
@section('sidebar')@include('partials.sidebar-mahasiswa')@endsection

@section('content')
    <div class="page-head">
        <a href="{{ route('mahasiswa.produk.index') }}" class="small strong row gap-xs items-center" style="color:var(--forest-700);margin-bottom:0.75rem"><x-icon name="chevron-left" :size="16" /> Kembali</a>
        <h1 class="page-head__title">Tambah Produk Baru</h1>
        <p class="page-head__desc">Lengkapi detail produk. Setelah dikirim, produk menunggu verifikasi admin.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error mb-md"><x-icon name="alert" :size="18" /><span>Periksa kembali isian formulir di bawah.</span></div>
    @endif

    <form method="POST" action="{{ route('mahasiswa.produk.store') }}" enctype="multipart/form-data" data-loading>
        @csrf
        @include('mahasiswa.produk._form')
    </form>
@endsection
