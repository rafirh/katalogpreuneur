# KatalogPreneur UB

Katalog digital resmi produk mahasiswa **Universitas Brawijaya** — mendukung **SDG 8 (Decent Work and Economic Growth)**.

Satu etalase terkurasi untuk menemukan produk wirausaha mahasiswa UB (kuliner, fashion, kerajinan, jasa), siap dipesan langsung melalui WhatsApp.

Dibangun dengan **Laravel 13**, **PHP 8.4**, **MySQL / MariaDB**, **Blade**, **Eloquent**, dan sistem desain kustom (CSS).

---

## Fitur

### Pengunjung (publik)
- Landing page editorial (hero, kategori dinamis, produk unggulan, seksi SDG 8).
- Katalog publik dengan **pencarian**, **filter kategori**, **pengurutan**, dan **paginasi**.
- Halaman detail produk dengan tombol **Pesan via WhatsApp** (nomor dinormalisasi ke format internasional).
- Hanya produk **Disetujui** yang tampil. Produk menunggu/ditolak -> `404`.

### Mahasiswa (penjual)
- Registrasi **khusus email `@ub.ac.id`** (validasi server-side).
- Login / logout, manajemen profil & nomor WhatsApp, ganti kata sandi.
- Dashboard ringkasan (total, disetujui, menunggu, ditolak).
- CRUD produk milik sendiri, upload foto (JPG/PNG/WEBP, maks 4 MB), pratinjau gambar.
- Melihat status verifikasi & alasan penolakan.
- **Otomatisasi**: produk baru -> `menunggu`; produk `disetujui` yang diedit -> kembali `menunggu`.

### Admin
- Dashboard statistik (penjual, total produk, menunggu, disetujui, ditolak, per kategori).
- Verifikasi produk: tinjau, **setujui**, atau **tolak** (alasan wajib, via modal).
- CRUD kategori — **tidak bisa dihapus** jika masih memiliki produk.
- Daftar penjual.

---

## Art direction

Identitas visual editorial kewirausahaan kampus:
- Kanvas warm off-white `#F8F7F2`, tinta deep forest green `#174C3C`, charcoal `#202620`, aksen amber `#D89B52`.
- Tipografi display **Fraunces** (serif) + UI **Plus Jakarta Sans**.
- Garis penuntun tipis, whitespace terukur, foto produk sebagai elemen utama — bukan grid kartu generik.

---

## Struktur database

| Tabel | Kolom kunci |
|-------|-------------|
| `users` | id, name, email (unik), password, **role** (`admin`/`mahasiswa`), **whatsapp_number**, timestamps |
| `kategori` | id, nama (unik), slug (unik), deskripsi, ikon, timestamps |
| `produk` | id, user_id (FK), kategori_id (FK, restrict), nama, deskripsi, harga, stok, foto, **status** (`menunggu`/`disetujui`/`ditolak`), alasan_penolakan, timestamps |

Relasi: `User hasMany Produk`, `Kategori hasMany Produk`, `Produk belongsTo User & Kategori`. Indeks pada `users.role`, `produk.status`, `produk.kategori_id`, `(status, created_at)`.

---

## Aturan bisnis (diterapkan di server)

1. Hanya produk `disetujui` tampil di katalog publik.
2. Mahasiswa hanya dapat mengedit/menghapus produk miliknya (Policy + cek `user_id`, diuji).
3. Produk baru otomatis `menunggu`.
4. Produk `disetujui` yang diedit -> kembali `menunggu`.
5. Penolakan admin **wajib** beralasan.
6. Kategori dengan produk tidak dapat dihapus.
7. Persetujuan admin menghapus `alasan_penolakan`.
8. Otorisasi admin/mahasiswa via middleware `admin`/`mahasiswa` + Policy.
9. Harga integer >= 0; 10. Stok integer >= 0.
11. Validasi tipe & ukuran berkas foto.
12. Validasi penuh sebelum menyimpan (`FormRequest`).
13. Produk pending/ditolak -> `404` di URL publik.
14. `user_id`/`status` **tidak pernah** diambil dari request (overwrite di `prepareForValidation`).


---

## Instalasi

Prasyarat: PHP >= 8.3, Composer, Node.js + npm, MySQL/MariaDB.

```bash
cd katalogpreneur

# 1. Dependency
composer install
npm install

# 2. Environment
cp .env.example .env
php artisan key:generate

# 3. Konfigurasi database (sesuaikan .env)
mysql -u root -e "CREATE DATABASE katalogpreneur CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
# .env: DB_CONNECTION=mysql  DB_DATABASE=katalogpreneur  DB_USERNAME=root  DB_PASSWORD=

# 4. Migrasi + data awal
php artisan migrate:fresh --seed

# 5. Storage & asset
php artisan storage:link
npm run build          # atau untuk pengembangan: npm run dev

# 6. Jalankan
php artisan serve
```

Aplikasi berjalan di **http://127.0.0.1:8000**.

---

## Akun hasil seeder

| Peran | Email | Kata sandi |
|-------|-------|------------|
| Admin | admin@ub.ac.id | password |
| Penjual (contoh) | alya.rahmadani@student.ub.ac.id | password |
| Penjual (contoh) | bagas.prasetyo@student.ub.ac.id | password |

Membuat admin baru:

```bash
php artisan tinker
>>> App\Models\User::create(['name'=>'Admin Baru','email'=>'admin2@ub.ac.id','password'=>'password','role'=>'admin']);

---

## Pengujian

```bash
php artisan test
```

**Hasil: 30 test, 82 assertions — semua lulus.**

Cakupan: registrasi email UB (positif/negatif), login/logout, redirect per peran, buat produk -> menunggu, tolak injeksi status/owner, validasi harga/stok negatif, edit produk sendiri vs orang lain (403), edit produk disetujui -> menunggu, hapus produk, approve/reject (wajib alasan), non-admin dilarang, CRUD kategori + proteksi hapus, katalog hanya disetujui, detail pending -> 404, pencarian, filter kategori, format URL WhatsApp.

---

## Ringkasan rute

```
GET  /                                   Beranda
GET  /katalog                            Katalog publik (search, filter, sort, paginasi)
GET  /produk/{produk}                    Detail produk (hanya disetujui)
GET  /tentang                            Tentang & panduan verifikasi
GET/POST /login  /register               Autentikasi (guest)
POST /logout                             Keluar

# Mahasiswa (auth + middleware mahasiswa)
GET  /mahasiswa/dashboard
GET  /mahasiswa/produk                   Daftar produk saya (+ filter status)
GET  /mahasiswa/produk/create
POST /mahasiswa/produk
GET  /mahasiswa/produk/{produk}
GET  /mahasiswa/produk/{produk}/edit
PUT  /mahasiswa/produk/{produk}
DELETE /mahasiswa/produk/{produk}
GET/PUT /mahasiswa/profil

# Admin (auth + middleware admin)
GET  /admin/dashboard
GET  /admin/verifikasi[?status=&q=]
GET  /admin/verifikasi/{produk}
PATCH /admin/verifikasi/{produk}/setujui
PATCH /admin/verifikasi/{produk}/tolak
GET/POST /admin/kategori
PUT  /admin/kategori/{kategori}
DELETE /admin/kategori/{kategori}
GET  /admin/mahasiswa
```

---

## Arsitektur

- **Controllers**: `AuthController`, `HomeController`, `KatalogController`, `Mahasiswa\{Dashboard,Produk,Profile}Controller`, `Admin\{Dashboard,Produk,Kategori,Mahasiswa}Controller`.
- **Form Requests**: `Auth\{Register,Login}Request`, `Produk\{Store,Update}ProdukRequest`, `Kategori\KategoriRequest`.
- **Policy**: `ProdukPolicy` (view/update/delete berbasis kepemilikan).
- **Middleware**: `EnsureUserIsAdmin`, `EnsureUserIsMahasiswa` (alias `admin`/`mahasiswa`).
- **Models**: `User`, `Kategori`, `Produk`.
- **Views**: layout publik, layout dashboard (sidebar responsif), komponen Blade (icon, card, status-badge, pagination, brand), halaman per peran.

---

## Batasan yang diketahui

- Verifikasi email tidak diwajibkan; integrasi SSO UB tidak diimplementasikan (sesuai scope).
- Pembayaran tidak diproses di aplikasi — pembeli menghubungi penjual via WhatsApp.
- Foto produk seeder berupa ilustrasi SVG kategori; upload pengguna menyimpan file asli ke `storage/app/public/produk`.
- Asset frontend perlu `npm run build` (atau `npm run dev`) sebelum dipakai.
- Nomor WhatsApp divalidasi untuk format Indonesia (diawali `08`).

---

## Lisensi

Proyek contoh untuk keperluan akademik Universitas Brawijaya. Bebas dikembangkan untuk kebutuhan internal kampus.

```
