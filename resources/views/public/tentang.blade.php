@extends('layouts.public')

@section('title', 'Tentang — KatalogPreneur UB')

@section('content')
    <section class="section" style="padding-top:3.5rem">
        <div class="container" style="max-width:820px">
            <span class="eyebrow">Tentang Kami</span>
            <h1 class="display" style="font-size:clamp(2.2rem,5vw,3.4rem);margin-top:0.75rem">Katalog resmi wirausaha mahasiswa Universitas Brawijaya.</h1>
            <p class="lead" style="margin-top:1.5rem">Banyak mahasiswa UB menjalankan usaha kecil — kuliner, fashion, kerajinan, hingga jasa kreatif. Namun promosi mereka tersebar di status WhatsApp dan grup chat. KatalogPreneur UB menyatukan semuanya dalam satu katalog digital yang terkurasi dan siap dipesan.</p>
        </div>
    </section>

    <section class="section--tight">
        <div class="container">
            <div class="detail-info-grid" style="grid-template-columns:repeat(3,1fr)">
                <div><div class="k">Masalah</div><div class="v" style="font-weight:500">Promosi tersebar &amp; sulit ditemukan</div></div>
                <div><div class="k">Solusi</div><div class="v" style="font-weight:500">Satu etalase digital terkurasi</div></div>
                <div><div class="k">Tujuan</div><div class="v" style="font-weight:500">Mendukung SDG 8</div></div>
            </div>
        </div>
    </section>

    <section class="section" id="sdg">
        <div class="container" style="max-width:820px">
            <h2 class="section-title">Bagaimana verifikasi bekerja</h2>
            <div class="stack gap-md mt-lg">
                <div class="panel"><div class="panel__body row gap-md items-center">
                    <span class="avatar">1</span>
                    <div><div class="strong">Penjual mendaftar</div><div class="small muted">Mahasiswa mendaftar dengan email @ub.ac.id dan mengisi nomor WhatsApp.</div></div>
                </div></div>
                <div class="panel"><div class="panel__body row gap-md items-center">
                    <span class="avatar">2</span>
                    <div><div class="strong">Mengunggah produk</div><div class="small muted">Produk baru otomatis berstatus menunggu verifikasi admin.</div></div>
                </div></div>
                <div class="panel"><div class="panel__body row gap-md items-center">
                    <span class="avatar">3</span>
                    <div><div class="strong">Admin memverifikasi</div><div class="small muted">Produk disetujui tampil di katalog, atau ditolak dengan alasan yang jelas.</div></div>
                </div></div>
                <div class="panel"><div class="panel__body row gap-md items-center">
                    <span class="avatar">4</span>
                    <div><div class="strong">Pembeli memesan</div><div class="small muted">Pengunjung menghubungi penjual langsung melalui WhatsApp.</div></div>
                </div></div>
            </div>
        </div>
    </section>

    <section class="section--tight">
        <div class="container">
            <div class="cta-strip">
                <div><h2 class="cta-strip__title">Siap memulai?</h2><p class="cta-strip__desc">Bergabunglah dengan mahasiswa UB lainnya dan tampilkan produkmu di katalog resmi.</p></div>
                <a href="{{ route('register') }}" class="btn btn-lg">Daftar sebagai Penjual <x-icon name="arrow-right" :size="18" /></a>
            </div>
        </div>
    </section>
@endsection
