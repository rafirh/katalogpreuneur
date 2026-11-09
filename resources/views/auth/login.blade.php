<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — KatalogPreneur UB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrap">
        <aside class="auth-aside">
            <x-brand />
            <div class="auth-aside__body">
                <p class="auth-aside__quote">“Satu katalog digital untuk semua produk mahasiswa UB.”</p>
                <p class="auth-aside__meta">Mendukung SDG 8 — Decent Work and Economic Growth.</p>
            </div>
            <div class="auth-aside__foot">© {{ date('Y') }} KatalogPreneur · Universitas Brawijaya</div>
        </aside>
        <main class="auth-main">
            <div class="auth-card">
                <h1 class="auth-title">Masuk</h1>
                <p class="auth-sub">Kelola etalase produkmu atau verifikasi produk sebagai admin.</p>

                @if ($errors->any())
                    <div class="alert alert-error mb-md">
                        <x-icon name="alert" :size="18" />
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" data-loading>
                    @csrf
                    <div class="field">
                        <label class="label" for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="input @error('email') is-invalid @enderror" placeholder="nama@ub.ac.id" required autofocus autocomplete="username">
                    </div>
                    <div class="field">
                        <label class="label" for="password">Kata sandi</label>
                        <input id="password" type="password" name="password" class="input @error('password') is-invalid @enderror" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                    <label class="row gap-sm small muted" style="margin-bottom:1.25rem;cursor:pointer">
                        <input type="checkbox" name="remember" value="1"> Ingat saya
                    </label>
                    <button type="submit" class="btn btn-block btn-lg"><span class="spinner"></span> Masuk</button>
                </form>

                <p class="auth-switch">Belum punya akun penjual? <a href="{{ route('register') }}">Daftar di sini</a></p>
                <p class="auth-switch"><a href="{{ route('home') }}" style="color:var(--ink-muted)">Kembali ke beranda</a></p>
            </div>
        </main>
    </div>
</body>
</html>
