@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('topbar_title', 'Kelola Kategori')
@section('sidebar')@include('partials.sidebar-admin')@endsection

@section('content')
    <div class="page-head page-head--row">
        <div>
            <h1 class="page-head__title">Kelola Kategori</h1>
            <p class="page-head__desc">Atur kategori usaha. Kategori yang masih memiliki produk tidak dapat dihapus.</p>
        </div>
        <button type="button" class="btn" data-modal-open="#create-kategori"><x-icon name="plus" :size="16" /> Kategori Baru</button>
    </div>

    @if ($errors->any())
        <div class="alert alert-error mb-md"><x-icon name="alert" :size="18" /><span>{{ $errors->first() }}</span></div>
    @endif

    <div class="panel">
        @forelse ($kategori as $k)
            <div class="kategori-item">
                <span class="kategori-item__icon"><x-icon name="tag" :size="18" /></span>
                <div style="flex:1;min-width:0">
                    <div class="kategori-item__name">{{ $k->nama }}</div>
                    <div class="kategori-item__desc">{{ $k->deskripsi ?: 'Tanpa deskripsi' }}</div>
                </div>
                <span class="kategori-item__count">{{ $k->produk_count }} produk</span>
                <div class="table__actions">
                    <button type="button" class="btn btn-outline btn-sm" data-modal-open="#edit-kategori-{{ $k->id }}"><x-icon name="edit" :size="14" /> Edit</button>
                    <form method="POST" action="{{ route('admin.kategori.destroy', $k) }}" data-confirm="Hapus kategori {{ $k->nama }}?">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger)" @disabled($k->produk_count > 0) title="{{ $k->produk_count > 0 ? 'Tidak dapat dihapus: masih ada produk' : 'Hapus' }}"><x-icon name="trash" :size="15" /></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty"><div class="empty__icon"><x-icon name="tag" :size="24"/></div><h3 class="empty__title">Belum ada kategori</h3><p class="empty__desc">Tambahkan kategori pertama.</p></div>
        @endforelse
    </div>

    {{-- create modal --}}
    <div class="modal-overlay" id="create-kategori">
        <div class="modal">
            <form method="POST" action="{{ route('admin.kategori.store') }}">
                @csrf
                <div class="modal__head"><h3 class="modal__title">Kategori baru</h3><button type="button" class="modal__close" data-modal-close><x-icon name="x" :size="16"/></button></div>
                <div class="modal__body">
                    <div class="field"><label class="label" for="nama">Nama kategori <span class="req">*</span></label><input id="nama" name="nama" class="input" placeholder="Mis. Kuliner" required></div>
                    <div class="field"><label class="label" for="deskripsi">Deskripsi</label><input id="deskripsi" name="deskripsi" class="input" placeholder="Deskripsi singkat kategori"></div>
                </div>
                <div class="modal__foot"><button type="button" class="btn btn-outline" data-modal-close>Batal</button><button type="submit" class="btn">Simpan</button></div>
            </form>
        </div>
    </div>

    @foreach ($kategori as $k)
        <div class="modal-overlay" id="edit-kategori-{{ $k->id }}">
            <div class="modal">
                <form method="POST" action="{{ route('admin.kategori.update', $k) }}">
                    @csrf @method('PUT')
                    <div class="modal__head"><h3 class="modal__title">Edit kategori</h3><button type="button" class="modal__close" data-modal-close><x-icon name="x" :size="16"/></button></div>
                    <div class="modal__body">
                        <div class="field"><label class="label">Nama kategori <span class="req">*</span></label><input name="nama" class="input" value="{{ $k->nama }}" required></div>
                        <div class="field"><label class="label">Deskripsi</label><input name="deskripsi" class="input" value="{{ $k->deskripsi }}"></div>
                    </div>
                    <div class="modal__foot"><button type="button" class="btn btn-outline" data-modal-close>Batal</button><button type="submit" class="btn">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
    @endforeach
@endsection
