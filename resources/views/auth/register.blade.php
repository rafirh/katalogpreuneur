<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Penjual — KatalogPreneur UB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-wrap">
        <aside class="auth-aside">
            <x-brand />
            <div class="auth-aside__body">
                <p class="auth-aside__quote">Bawa produkmu ke satu katalog resmi kampus.</p>
                <p class="auth-aside__meta">Daftar dengan email resmi @ub.ac.id. Gratis untuk mahasiswa Universitas Brawijaya.</p>
            </div>
            <div class="auth-aside__foot">© {{ date('Y') }} KatalogPreneur · Universitas Brawijaya</div>
        </aside>
        <main class="auth-main">
            <div class="auth-card">
                <h1 class="auth-title">Daftar Penjual</h1>
                <p class="auth-sub">Buat akun dengan email resmi Universitas Brawijaya.</p>

                @if ($errors->any())
                    <div class="alert alert-error mb-md">
                        <x-icon name="alert" :size="18" />
                        <div>@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" data-loading>
                    @csrf
                    <div class="field">
                        <label class="label" for="name">Nama lengkap <span class="req">*</span></label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" class="input @error('name') is-invalid @enderror" placeholder="Nama sesuai KTM" required autofocus>
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label class="label" for="email">Email UB <span class="req">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="input @error('email') is-invalid @enderror" placeholder="nama@ub.ac.id" required>
                        <span class="field-hint">Hanya email berdomain @ub.ac.id.</span>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label class="label" for="whatsapp_number">Nomor WhatsApp <span class="req">*</span></label>
                        <input id="whatsapp_number" type="tel" name="whatsapp_number" value="{{ old('whatsapp_number') }}" class="input @error('whatsapp_number') is-invalid @enderror" placeholder="081234567890" required>
                        @error('whatsapp_number')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-grid">
                        <div class="field">
                            <label class="label" for="password">Kata sandi <span class="req">*</span></label>
                            <input id="password" type="password" name="password" class="input @error('password') is-invalid @enderror" placeholder="Min. 8 karakter" required autocomplete="new-password">
                            @error('password')<span class="field-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label class="label" for="password_confirmation">Ulangi sandi <span class="req">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="input" placeholder="Ulangi kata sandi" required autocomplete="new-password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-lg"><span class="spinner"></span> Buat Akun Penjual</button>
                </form>

                <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
                <p class="auth-switch"><a href="{{ route('home') }}" style="color:var(--ink-muted)">Kembali ke beranda</a></p>
            </div>
        </main>
    </div>
</body>
</html>
