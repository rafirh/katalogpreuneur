<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KatalogPreneur UB — Katalog Produk Mahasiswa Universitas Brawijaya')</title>
    <meta name="description" content="@yield('meta_description', 'Satu katalog digital resmi untuk menemukan produk dari mahasiswa Universitas Brawijaya. Terkurasi dan siap dipesan melalui WhatsApp.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="site-header">
        <div class="container site-header__inner">
            <x-brand />

            @php
                $navActive = fn ($route) => request()->routeIs($route) ? 'is-active' : '';
            @endphp
            <nav class="nav" aria-label="Navigasi utama">
                <a href="{{ route('home') }}" class="nav__link {{ $navActive('home') }}">Beranda</a>
                <a href="{{ route('katalog.index') }}" class="nav__link {{ $navActive('katalog.*') }}">Jelajahi Produk</a>
                <a href="{{ route('tentang') }}" class="nav__link {{ $navActive('tentang') }}">Tentang</a>
            </nav>

            <div class="header-actions">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm">Dashboard Admin</a>
                    @else
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-sm">Dashboard Saya</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-sm">Daftar Penjual</a>
                @endauth
            </div>

            <button class="menu-toggle" data-menu-toggle aria-label="Buka menu" aria-expanded="false">
                <x-icon name="menu" :size="20" />
            </button>
        </div>

        <div class="mobile-nav" data-mobile-nav>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('katalog.index') }}">Jelajahi Produk</a>
            <a href="{{ route('tentang') }}">Tentang</a>
            <div class="mobile-nav__actions">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('mahasiswa.dashboard') }}" class="btn btn-sm btn-block">Dashboard Saya</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="flex:1">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-sm" style="flex:1">Daftar Penjual</a>
                @endauth
            </div>
        </div>
    </header>

    @if (session('status'))
        <div class="container" style="padding-top:1.25rem">
            <div class="alert alert-success">
                <x-icon name="check-circle" :size="18" />
                <span>{{ session('status') }}</span>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <x-brand />
                    <p class="footer-tagline">Katalog digital resmi produk mahasiswa Universitas Brawijaya. Mendukung tumbuhnya wirausaha muda untuk pertumbuhan ekonomi yang inklusif.</p>
                </div>
                <div class="footer-col">
                    <h4>Jelajahi</h4>
                    <ul>
                        <li><a href="{{ route('katalog.index') }}">Semua Produk</a></li>
                        <li><a href="{{ route('katalog.index', ['kategori' => 'kuliner']) }}">Kuliner</a></li>
                        <li><a href="{{ route('katalog.index', ['kategori' => 'fashion']) }}">Fashion</a></li>
                        <li><a href="{{ route('katalog.index', ['kategori' => 'jasa']) }}">Jasa</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Penjual</h4>
                    <ul>
                        <li><a href="{{ route('register') }}">Daftar sebagai Penjual</a></li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                        <li><a href="{{ route('tentang') }}">Panduan Verifikasi</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>SDG 8</h4>
                    <ul>
                        <li><a href="{{ route('tentang') }}#sdg">Decent Work &amp; Growth</a></li>
                        <li><a href="https://sdgs.un.org/goals/goal8" target="_blank" rel="noopener">Tentang SDG 8</a></li>
                        <li><a href="https://ub.ac.id" target="_blank" rel="noopener">Universitas Brawijaya</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} KatalogPreneur UB — Universitas Brawijaya</span>
                <span>Dibangun untuk mendukung SDG 8 · Decent Work and Economic Growth</span>
            </div>
        </div>
    </footer>
</body>
</html>
