<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — KatalogPreneur UB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <div class="sidebar-backdrop" data-sidebar-backdrop></div>
        <aside class="sidebar" data-sidebar>
            <x-brand />
            @yield('sidebar')
        </aside>

        <div class="main-area">
            <div class="topbar">
                <div class="row gap-md items-center">
                    <button class="menu-toggle sidebar-toggle" data-sidebar-toggle aria-label="Buka menu"><x-icon name="menu" :size="20" /></button>
                    <span class="topbar__title">@yield('topbar_title', 'Dashboard')</span>
                </div>
                <div class="topbar__right">
                    <a href="{{ route('katalog.index') }}" class="btn btn-ghost btn-sm hide-mobile">Lihat Katalog</a>
                    <div class="topbar-user hide-mobile">
                        <div class="text-right" style="text-align:right">
                            <div class="topbar-user__name">{{ auth()->user()->name }}</div>
                            <div class="topbar-user__role">{{ auth()->user()->isAdmin() ? 'Administrator' : 'Mahasiswa Penjual' }}</div>
                        </div>
                        <span class="avatar">{{ auth()->user()->inisial() }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm" title="Keluar"><x-icon name="logout" :size="18" /></button>
                    </form>
                </div>
            </div>

            <div class="content">
                @if (session('status'))
                    <div class="alert alert-success mb-md"><x-icon name="check-circle" :size="18" /><span>{{ session('status') }}</span></div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error mb-md"><x-icon name="alert" :size="18" /><span>{{ session('error') }}</span></div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
