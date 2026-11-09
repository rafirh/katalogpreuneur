@php($editing = isset($produk))
<div class="form-layout">
    <div class="panel"><div class="panel__body">
        <div class="field">
            <label class="label" for="nama">Nama produk <span class="req">*</span></label>
            <input id="nama" type="text" name="nama" value="{{ old('nama', $produk->nama ?? '') }}" class="input @error('nama') is-invalid @enderror" placeholder="Contoh: Nasi Bakar Sambal Matah" required>
            @error('nama')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-grid">
            <div class="field">
                <label class="label" for="kategori_id">Kategori <span class="req">*</span></label>
                <select id="kategori_id" name="kategori_id" class="select @error('kategori_id') is-invalid @enderror" required>
                    <option value="">Pilih kategori</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" @selected(old('kategori_id', $produk->kategori_id ?? '') == $k->id)>{{ $k->nama }}</option>
                    @endforeach
                </select>
                @error('kategori_id')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field">
                <label class="label" for="stok">Stok <span class="req">*</span></label>
                <input id="stok" type="number" name="stok" min="0" value="{{ old('stok', $produk->stok ?? '') }}" class="input @error('stok') is-invalid @enderror" placeholder="0" required>
                @error('stok')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="field">
            <label class="label" for="harga">Harga (Rupiah) <span class="req">*</span></label>
            <div class="input-prefix">
                <span class="prefix">Rp</span>
                <input id="harga" type="text" inputmode="numeric" name="harga" data-rupiah value="{{ old('harga', isset($produk) ? number_format($produk->harga,0,',','.') : '') }}" class="input @error('harga') is-invalid @enderror" placeholder="0" required>
            </div>
            @error('harga')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label class="label" for="deskripsi">Deskripsi <span class="req">*</span></label>
            <textarea id="deskripsi" name="deskripsi" class="textarea @error('deskripsi') is-invalid @enderror" placeholder="Jelaskan produk, bahan, ukuran, dan keunggulannya (min. 20 karakter)." required>{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
            <span class="field-hint">Semakin jelas, semakin mudah pembeli memutuskan.</span>
            @error('deskripsi')<span class="field-error">{{ $message }}</span>@enderror
        </div>
    </div></div>

    <div class="stack gap-md">
        <div class="panel"><div class="panel__body">
            <label class="label mb-sm" style="display:block">Foto produk</label>
            <div class="upload {{ isset($produk) && $produk->fotoUrl() ? 'has-preview' : '' }}" data-upload>
                <input type="file" name="foto" accept="image/png,image/jpeg,image/webp">
                @if (isset($produk) && $u = $produk->fotoUrl())
                    <img class="upload__preview" src="{{ $u }}" alt="Pratinjau">
                @else
                    <img class="upload__preview" alt="Pratinjau">
                @endif
                <div class="upload__placeholder">
                    <x-icon name="camera" :size="26" />
                    <div><strong>Klik untuk unggah</strong> atau seret foto</div>
                    <span class="xsmall">JPG, PNG, WEBP · maks 4 MB</span>
                </div>
            </div>
            @error('foto')<span class="field-error mt-sm" style="display:block">{{ $message }}</span>@enderror
        </div></div>

        <div class="panel"><div class="panel__body">
            <div class="row gap-sm items-center" style="color:var(--forest-700)"><x-icon name="info" :size="18" /><span class="strong small">Tentang verifikasi</span></div>
            <p class="small muted mt-sm">Produk baru berstatus <strong>Menunggu</strong>. Saat produk yang sudah disetujui kamu edit, status otomatis kembali menunggu verifikasi admin.</p>
        </div></div>
    </div>
</div>

<div class="form-actions">
    <a href="{{ route('mahasiswa.produk.index') }}" class="btn btn-outline">Batal</a>
    <button type="submit" class="btn"><span class="spinner"></span> {{ $editing ? 'Simpan Perubahan' : 'Kirim untuk Verifikasi' }}</button>
</div>
