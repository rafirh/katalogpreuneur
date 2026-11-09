<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Kuliner', 'deskripsi' => 'Makanan, minuman, dan camilan buatan mahasiswa.', 'ikon' => 'bowl'],
            ['nama' => 'Fashion', 'deskripsi' => 'Pakaian, aksesoris, dan thrift pilihan mahasiswa.', 'ikon' => 'shirt'],
            ['nama' => 'Kerajinan', 'deskripsi' => 'Karya tangan, dekorasi, dan suvenir kreatif.', 'ikon' => 'craft'],
            ['nama' => 'Jasa', 'deskripsi' => 'Desain, percetakan, jasa digital, dan layanan kreatif.', 'ikon' => 'service'],
            ['nama' => 'Kecantikan', 'deskripsi' => 'Produk perawatan kulit dan kosmetik lokal.', 'ikon' => 'sparkle'],
            ['nama' => 'Pertanian', 'deskripsi' => 'Tanaman hias, hidroponik, dan hasil kebun.', 'ikon' => 'leaf'],
        ];

        foreach ($data as $item) {
            $kategori = Kategori::firstOrNew(['nama' => $item['nama']]);
            $kategori->fill($item);

            if (! $kategori->exists) {
                $kategori->slug = Kategori::uniqueSlug($item['nama']);
            }

            $kategori->save();
        }
    }
}
