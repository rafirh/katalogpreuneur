<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $penjual = [
            ['name' => 'Alya Rahmadani', 'email' => 'alya.rahmadani@student.ub.ac.id', 'wa' => '081234567801'],
            ['name' => 'Bagas Prasetyo', 'email' => 'bagas.prasetyo@student.ub.ac.id', 'wa' => '081234567802'],
            ['name' => 'Citra Larasati', 'email' => 'citra.larasati@student.ub.ac.id', 'wa' => '081234567803'],
            ['name' => 'Dimas Aditya', 'email' => 'dimas.aditya@student.ub.ac.id', 'wa' => '081234567804'],
        ];

        $users = collect($penjual)->map(fn ($p) => User::firstOrCreate(
            ['email' => $p['email']],
            [
                'name' => $p['name'],
                'password' => 'password',
                'role' => User::ROLE_MAHASISWA,
                'whatsapp_number' => $p['wa'],
                'email_verified_at' => now(),
            ],
        ));

        $kategori = Kategori::pluck('id', 'nama');

        $produk = $this->data();

        foreach ($produk as $i => [$nama, $kategoriNama, $deskripsi, $harga, $stok, $gelap, $terang]) {
            $status = match ($i % 7) {
                5 => Produk::STATUS_MENUNGGU,
                6 => Produk::STATUS_DITOLAK,
                default => Produk::STATUS_DISETUJUI,
            };

            Produk::create([
                'user_id' => $users[$i % $users->count()]->id,
                'kategori_id' => $kategori[$kategoriNama],
                'nama' => $nama,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'stok' => $stok,
                'foto' => null, // Will be set after the record is created
                'status' => $status,
                'alasan_penolakan' => $status === Produk::STATUS_DITOLAK
                    ? 'Foto produk kurang jelas dan belum menampilkan produk secara utuh. Mohon unggah ulang dengan pencahayaan lebih baik.'
                    : null,
            ]);
        }
    }

    private function makeImage(string $nama, string $kategori, string $gelap, string $terang): string
    {
        $slug = Str::slug($nama);
        $path = "produk/seed-{$slug}.svg";

        // Deterministic-but-varied abstract composition so seeded cards feel photographic
        // rather than like identical letter tiles.
        $seed = crc32($nama);
        mt_srand($seed);

        // Category-aware central motif (simple geometric silhouette).
        $motif = match ($kategori) {
            'Kuliner' => '<circle cx="400" cy="380" r="150" fill="none" stroke="rgba(255,255,255,0.55)" stroke-width="26"/><path d="M290 300v170M510 300c-40 0-60 40-60 90s20 80 60 80" stroke="rgba(255,255,255,0.55)" stroke-width="22" fill="none"/>',
            'Fashion' => '<path d="M300 300l70-40h60l70 40-30 70-40-20v220H370V350l-40 20z" fill="rgba(255,255,255,0.5)"/>',
            'Kerajinan' => '<path d="M400 250l38 78 86 12-62 60 15 86-77-41-77 41 15-86-62-60 86-12z" fill="rgba(255,255,255,0.5)"/>',
            'Jasa' => '<rect x="300" y="270" width="200" height="220" rx="18" fill="none" stroke="rgba(255,255,255,0.55)" stroke-width="24"/><path d="M345 400l38 40 72-80" stroke="rgba(255,255,255,0.55)" stroke-width="24" fill="none"/>',
            'Kecantikan' => '<rect x="350" y="300" width="100" height="190" rx="20" fill="rgba(255,255,255,0.5)"/><rect x="380" y="250" width="40" height="54" fill="rgba(255,255,255,0.7)"/>',
            'Pertanian' => '<path d="M400 470V300" stroke="rgba(255,255,255,0.55)" stroke-width="20"/><path d="M400 360c-60-10-90-60-90-110 50 0 100 40 90 110zM400 420c60-10 90-60 90-110-50 0-100 40-90 110z" fill="rgba(255,255,255,0.5)"/>',
            default => '<circle cx="400" cy="380" r="120" fill="rgba(255,255,255,0.5)"/>',
        };

        $shapes = '<rect width="800" height="800" fill="url(#g)"/>'
            .'<rect width="800" height="800" fill="url(#v)"/>';

        for ($i = 0; $i < 3; $i++) {
            $cx = mt_rand(100, 700);
            $cy = mt_rand(100, 700);
            $r = mt_rand(120, 240);
            $op = (mt_rand(8, 16) / 100);
            $tint = mt_rand(0, 1) ? '#ffffff' : '#0a241a';
            $shapes .= "<circle cx=\"{$cx}\" cy=\"{$cy}\" r=\"{$r}\" fill=\"{$tint}\" fill-opacity=\"{$op}\"/>";
        }

        $bandY = mt_rand(560, 640);
        $shapes .= "<rect x=\"0\" y=\"{$bandY}\" width=\"800\" height=\"".(800 - $bandY)."\" fill=\"#0a241a\" fill-opacity=\"0.10\"/>";
        $shapes .= $motif;

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 800 800">'
            .'<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">'
            ."<stop offset=\"0\" stop-color=\"{$terang}\"/><stop offset=\"1\" stop-color=\"{$gelap}\"/></linearGradient>"
            .'<radialGradient id="v" cx="0.5" cy="0.42" r="0.75">'
            .'<stop offset="0.55" stop-color="#000000" stop-opacity="0"/><stop offset="1" stop-color="#0a241a" stop-opacity="0.16"/></radialGradient>'
            .'</defs>'
            .$shapes
            .'</svg>';

        Storage::disk('public')->put($path, $svg);

        return $path;
    }

    private function data(): array
    {
        return [
            ['Nasi Bakar Sambal Matah', 'Kuliner', 'Nasi bakar gurih dengan isian ayam suwir dan sambal matah segar, dibungkus daun pisang dan dipanggang di pesanan. Cocok untuk makan siang maupun bekal kuliah.', 18000, 25, '#c6753f', '#f2dfc8'],
            ['Es Kopi Susu Gula Aren', 'Kuliner', 'Kopi arabika lokal dengan susu segar dan gula aren cair. Rasa seimbang, tidak terlalu manis, disajikan dingin dalam botol 500ml.', 15000, 40, '#5b3a29', '#e3c9b0'],
            ['Brownies Fudgy Panggang', 'Kuliner', 'Brownies cokelat pekat dengan tekstur fudgy, dikemas per loyang 20x10 cm. Cocok untuk hadiah atau teman belajar.', 45000, 12, '#4a2c1a', '#d9b99b'],
            ['Kaos Premium Cotton Combed 30s', 'Fashion', 'Kaos oversize dari cotton combed 30s, jahitan rapi dan sablon plastisol tahan lama. Tersedia ukuran M, L, XL.', 85000, 30, '#33413a', '#d7e3d5'],
            ['Tote Bag Kanvas Handmade', 'Fashion', 'Tote bag kanvas tebal dengan bordir tangan. Kuat menampung laptop 14 inci dan buku kuliah.', 65000, 18, '#8a7456', '#ece3d2'],
            ['Batik Tulis Motif Malang', 'Fashion', 'Kain batik tulis motif khas Malang, pewarna alami, panjang 2 meter. Setiap lembar unik dan terbatas.', 250000, 6, '#5d3a1a', '#e8d3b0'],
            ['Lilin Aromaterapi Soy Wax', 'Kerajinan', 'Lilin aromaterapi dari soy wax dengan aroma lavender dan vanila. Waktu bakar sekitar 30 jam dalam jar kaca.', 55000, 22, '#96613b', '#f0e2cf'],
            ['Papan Bunga Kering Estetik', 'Kerajinan', 'Dekorasi dinding dari rangkaian bunga kering asli, dipigura kayu pinus. Sentuhan hangat untuk kamar kos.', 120000, 8, '#8a6a4f', '#eadfd2'],
            ['Gelang Rajut Manik', 'Kerajinan', 'Gelang rajut dengan manik-manik pilihan, bisa custom nama sesuai permintaan. Cocok untuk hadiah teman.', 25000, 50, '#b07d4f', '#f1e5d5'],
            ['Jasa Desain Feed Instagram', 'Jasa', 'Paket desain 5 feed Instagram dengan konsep rapi dan konsisten. Revisi 2 kali, file siap unggah.', 150000, 10, '#1f4e3d', '#dce8d8'],
            ['Jasa Cetak Stiker Custom', 'Jasa', 'Cetak stiker vinyl tahan air, minimal order 20 lembar. Bisa custom bentuk dan ukuran.', 30000, 100, '#3f5d4c', '#e2ecdf'],
            ['Jasa Foto Produk UMKM', 'Jasa', 'Sesi foto produk 10 foto dengan latar bersih, termasuk editing warna dan background. Untuk kebutuhan katalog online.', 200000, 7, '#2c3e35', '#d6e2d4'],
            ['Serum Vitamin C Lokal', 'Kecantikan', 'Serum wajah dengan vitamin C 10% dan niacinamide, membantu mencerahkan dan meratakan warna kulit. Ukuran 30ml.', 89000, 15, '#c98f5a', '#f3e4d3'],
            ['Sabun Organik Oatmeal', 'Kecantikan', 'Sabun batang organik dengan oatmeal dan madu, lembut untuk kulit sensitif. Dibuat dalam batch kecil.', 35000, 35, '#b58a5e', '#efe0cd'],
            ['Tanaman Hias Monstera', 'Pertanian', 'Monstera deliciosa sehat dalam pot terakota diameter 15cm, tinggi sekitar 40cm. Siap mempercantik ruangan.', 95000, 10, '#2f5d3a', '#d5e6d3'],
            ['Paket Hidroponik Selada', 'Pertanian', 'Selada hidroponik segar dipanen harian, dikemas 250 gram. Bebas pestisida dan cocok untuk salad.', 20000, 20, '#3f7a44', '#dcecd9'],
        ];
    }
}
