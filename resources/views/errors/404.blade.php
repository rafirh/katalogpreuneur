@extends('layouts.public')
@section('title', 'Halaman Tidak Ditemukan')
@section('content')
    <section class="section" style="padding-top:5rem">
        <div class="container" style="max-width:640px;text-align:center">
            <div class="display" style="font-size:5rem;color:var(--forest-800);line-height:1">404</div>
            <h1 class="display" style="font-size:1.8rem;margin-top:1rem">Halaman tidak ditemukan</h1>
            <p class="muted mt-sm">Produk atau halaman yang Anda cari tidak tersedia.</p>
            <a href="{{ route('katalog.index') }}" class="btn mt-lg">Jelajahi Katalog</a>
        </div>
    </section>
@endsection
