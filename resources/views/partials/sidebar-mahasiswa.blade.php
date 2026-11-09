<div class="sidebar__section">Penjual</div>
<nav class="sidebar__nav">
    <a href="{{ route('mahasiswa.dashboard') }}" class="sidebar__link {{ request()->routeIs('mahasiswa.dashboard') ? 'is-active' : '' }}">
        <x-icon name="layout" :size="18" /> Ringkasan
    </a>
    <a href="{{ route('mahasiswa.produk.index') }}" class="sidebar__link {{ request()->routeIs('mahasiswa.produk.*') ? 'is-active' : '' }}">
        <x-icon name="box" :size="18" /> Produk Saya
    </a>
    <a href="{{ route('mahasiswa.produk.create') }}" class="sidebar__link {{ request()->routeIs('mahasiswa.produk.create') ? 'is-active' : '' }}">
        <x-icon name="plus" :size="18" /> Tambah Produk
    </a>
    <a href="{{ route('mahasiswa.profile.edit') }}" class="sidebar__link {{ request()->routeIs('mahasiswa.profile.*') ? 'is-active' : '' }}">
        <x-icon name="user" :size="18" /> Profil &amp; WhatsApp
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
        <div class="sidebar__user-role">Mahasiswa Penjual</div>
    </div>
</div>
