@extends('layouts.app')

@section('title', 'Profil')
@section('topbar_title', 'Profil & WhatsApp')
@section('sidebar')@include('partials.sidebar-mahasiswa')@endsection

@section('content')
    <div class="page-head">
        <h1 class="page-head__title">Profil &amp; WhatsApp</h1>
        <p class="page-head__desc">Nomor WhatsApp digunakan pembeli untuk memesan produkmu langsung dari katalog.</p>
    </div>

    <div class="content-narrow">
        <div class="panel"><div class="panel__body">
            <div class="row gap-md items-center mb-lg">
                <span class="avatar avatar-lg">{{ $user->inisial() }}</span>
                <div><div class="strong" style="font-size:1.1rem">{{ $user->name }}</div><div class="small muted">{{ $user->email }}</div></div>
            </div>

            @if ($errors->any())
                <div class="alert alert-error mb-md"><x-icon name="alert" :size="18" /><span>{{ $errors->first() }}</span></div>
            @endif

            <form method="POST" action="{{ route('mahasiswa.profile.update') }}" data-loading>
                @csrf @method('PUT')
                <div class="form-grid">
                    <div class="field">
                        <label class="label" for="name">Nama lengkap <span class="req">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="input @error('name') is-invalid @enderror" required>
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label class="label" for="whatsapp_number">Nomor WhatsApp <span class="req">*</span></label>
                        <input id="whatsapp_number" type="tel" name="whatsapp_number" value="{{ old('whatsapp_number', $user->whatsapp_number) }}" class="input @error('whatsapp_number') is-invalid @enderror" placeholder="081234567890" required>
                        @error('whatsapp_number')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <hr class="divider mb-md">
                <div class="small muted mb-sm">Ganti kata sandi (opsional)</div>
                <div class="form-grid">
                    <div class="field">
                        <label class="label" for="password">Kata sandi baru</label>
                        <input id="password" type="password" name="password" class="input @error('password') is-invalid @enderror" placeholder="Kosongkan bila tidak diubah" autocomplete="new-password">
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label class="label" for="password_confirmation">Ulangi kata sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="input" placeholder="Ulangi kata sandi" autocomplete="new-password">
                    </div>
                </div>

                <div class="form-actions"><button type="submit" class="btn"><span class="spinner"></span> Simpan Perubahan</button></div>
            </form>
        </div></div>
    </div>
@endsection
