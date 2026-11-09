@extends('layouts.public')
@section('title', 'Akses Ditolak')
@section('content')
    <section class="section" style="padding-top:5rem">
        <div class="container" style="max-width:640px;text-align:center">
            <div class="display" style="font-size:5rem;color:var(--forest-800);line-height:1">403</div>
            <h1 class="display" style="font-size:1.8rem;margin-top:1rem">Akses ditolak</h1>
            <p class="muted mt-sm">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
            <a href="{{ route('home') }}" class="btn mt-lg">Kembali ke Beranda</a>
        </div>
    </section>
@endsection
