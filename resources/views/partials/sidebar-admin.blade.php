<div class="sidebar__section">Administrator</div>
<nav class="sidebar__nav">
    <a href="{{ route('admin.dashboard') }}" class="sidebar__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
        <x-icon name="layout" :size="18" /> Ringkasan
    </a>
    <a href="{{ route('admin.verifikasi.index') }}" class="sidebar__link {{ request()->routeIs('admin.verifikasi.*') ? 'is-active' : '' }}">
        <x-icon name="check-circle" :size="18" /> Verifikasi Produk
    </a>
    <a href="{{ route('admin.kategori.index') }}" class="sidebar__link {{ request()->routeIs('admin.kategori.*') ? 'is-active' : '' }}">
        <x-icon name="tag" :size="18" /> Kelola Kategori
    </a>
    <a href="{{ route('admin.mahasiswa.index') }}" class="sidebar__link {{ request()->routeIs('admin.mahasiswa.*') ? 'is-active' : '' }}">
        <x-icon name="users" :size="18" /> Data Penjual
    </a>
</nav>
<div class="sidebar__spacer"></div>
<div class="sidebar__section">Publik</div>
<nav class="sidebar__nav" style="margin-bottom:1rem">
    <a href="{{ route('katalog.index') }}" class="sidebar__link"><x-icon name="grid" :size="18" /> Lihat Katalog</a>
</nav>
<div class="sidebar__user">
    <span class="avatar">{{ auth()->user()->inisial() }}</span>
    <div class="sidebar__user-info">
        <div class="sidebar__user-name">{{ auth()->user()->name }}</div>
        <div class="sidebar__user-role">Administrator</div>
    </div>
</div>
