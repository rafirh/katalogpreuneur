@extends('layouts.public')

@section('content')
    {{-- HERO --}}
    <section class="hero">
        <div class="container hero__inner">
            <div>
                <span class="hero__eyebrow reveal"><span class="dot"></span> Inisiatif Kewirausahaan Mahasiswa UB</span>
                <h1 class="hero__title reveal reveal-1">Temukan Produk <em>Kreatif</em> Mahasiswa UB</h1>
                <p class="hero__lead reveal reveal-2">Jelajahi berbagai produk dan usaha kreatif mahasiswa Universitas Brawijaya dalam satu katalog digital yang terkurasi.</p>
                <div class="hero__cta reveal reveal-3">
                    <a href="{{ route('katalog.index') }}" class="btn btn-lg">Jelajahi Katalog <x-icon name="arrow-right" :size="18" /></a>
                    <a href="{{ route('register') }}" class="btn btn-outline btn-lg">Mulai Berwirausaha</a>
                </div>
                <div class="hero__stats reveal reveal-3">
                    <div><div class="hero__stat-num">{{ number_format($statistik['produk']) }}</div><div class="hero__stat-label">Produk terkurasi</div></div>
                    <div><div class="hero__stat-num">{{ number_format($statistik['penjual']) }}</div><div class="hero__stat-label">Penjual mahasiswa</div></div>
                    <div><div class="hero__stat-num">{{ number_format($statistik['kategori']) }}</div><div class="hero__stat-label">Kategori usaha</div></div>
                </div>
            </div>

            <div class="hero__visual reveal reveal-2">
                <div class="hero__collage">
                    @forelse ($produkUnggulan->take(4) as $p)
                        <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama }}" loading="lazy">
                    @empty
                        <img src="https://ui-avatars.com/api/?name=K&size=400&background=4a7c59&color=fff&bold=true&format=svg" alt="K">
                        <img src="https://ui-avatars.com/api/?name=U&size=400&background=6b9c7e&color=fff&bold=true&format=svg" alt="U">
                        <img src="https://ui-avatars.com/api/?name=B&size=400&background=8aba9a&color=fff&bold=true&format=svg" alt="B">
                        <img src="https://ui-avatars.com/api/?name=8&size=400&background=a8d5ba&color=fff&bold=true&format=svg" alt="8">
                    @endforelse
                </div>
                <div class="hero__badge"><strong>100% Mahasiswa UB</strong>Setiap produk diverifikasi admin sebelum tayang.</div>
            </div>
        </div>
    </section>

    {{-- KATEGORI --}}
    @if ($kategori->isNotEmpty())
        <section class="section--tight">
            <div class="container">
                <div class="section-divider">
                    <h2 class="section-title">Kategori Pilihan</h2>
                    <a href="{{ route('katalog.index') }}" class="small strong" style="color:var(--forest-700)">Lihat semua</a>
                </div>
                <div class="cat-strip">
                    @foreach ($kategori as $k)
                        @php
                            $iconMap = ['bowl' => 'bowl', 'shirt' => 'shirt', 'craft' => 'craft', 'service' => 'service', 'sparkle' => 'sparkles', 'leaf' => 'leaf'];
                            $icon = $iconMap[$k->ikon] ?? 'grid';
                        @endphp
                        <a href="{{ route('katalog.index', ['kategori' => $k->slug]) }}" class="cat-tile">
                            <span class="cat-tile__icon"><x-icon :name="$icon" :size="24" :stroke="1.6" /></span>
                            <span class="cat-tile__name">{{ $k->nama }}</span>
                            <span class="cat-tile__count">{{ $k->produk_disetujui_count }} produk</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- PRODUK UNGGULAN --}}
    <section class="section">
        <div class="container">
            <div class="section-divider">
                <div><span class="eyebrow">Baru &amp; Terkurasi</span><h2 class="section-title mt-sm">Produk dari Mahasiswa</h2></div>
                <a href="{{ route('katalog.index') }}" class="btn btn-outline btn-sm">Semua Produk</a>
            </div>
            @if ($produkUnggulan->isEmpty())
                <div class="empty panel">
                    <div class="empty__icon"><x-icon name="box" :size="24" /></div>
                    <h3 class="empty__title">Belum ada produk</h3>
                    <p class="empty__desc">Produk mahasiswa yang telah disetujui akan tampil di sini.</p>
                </div>
            @else
                <div class="product-grid">
                    @foreach ($produkUnggulan as $produk)
                        <x-produk-card :produk="$produk" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- SDG 8 --}}
    <section class="sdg-band" id="sdg">
        <div class="container sdg-band__inner">
            <div>
                <div class="sdg-band__tag">Sustainable Development Goal</div>
                <div class="sdg-band__num">08</div>
                <h2 class="sdg-band__title">Pertumbuhan Ekonomi &amp; Pekerjaan Layak</h2>
                <p class="sdg-band__text">KatalogPreneur UB mendorong wirausaha muda kampus sebagai jalan menuju pekerjaan yang layak dan pertumbuhan ekonomi yang inklusif.</p>
            </div>
            <div class="sdg-points">
                <div class="sdg-point"><div class="sdg-point__icon"><x-icon name="store" :size="18" /></div><div><div class="sdg-point__title">Toko digital yang setara</div><div class="sdg-point__desc">Setiap mahasiswa mendapat etalase digital resmi tanpa biaya, memperluas jangkauan pasar.</div></div></div>
                <div class="sdg-point"><div class="sdg-point__icon"><x-icon name="shield" :size="18" /></div><div><div class="sdg-point__title">Terverifikasi &amp; terpercaya</div><div class="sdg-point__desc">Admin memverifikasi setiap produk sebelum tayang, membangun kepercayaan pembeli.</div></div></div>
                <div class="sdg-point"><div class="sdg-point__icon"><x-icon name="trending" :size="18" /></div><div><div class="sdg-point__title">Pemasaran yang terpusat</div><div class="sdg-point__desc">Dari status WhatsApp yang berserakan menjadi satu katalog yang mudah dijelajahi.</div></div></div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="section">
        <div class="container">
            <div class="cta-strip">
                <div><h2 class="cta-strip__title">Punya usaha sambil kuliah?</h2><p class="cta-strip__desc">Tampilkan produkmu di katalog resmi Universitas Brawijaya. Daftar dengan email UB dan mulai berjualan.</p></div>
                <a href="{{ route('register') }}" class="btn btn-lg">Daftar sebagai Penjual <x-icon name="arrow-right" :size="18" /></a>
            </div>
        </div>
    </section>
@endsection
