<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statistik = [
            'users' => User::where('role', User::ROLE_MAHASISWA)->count(),
            'total' => Produk::count(),
            'menunggu' => Produk::where('status', Produk::STATUS_MENUNGGU)->count(),
            'disetujui' => Produk::where('status', Produk::STATUS_DISETUJUI)->count(),
            'ditolak' => Produk::where('status', Produk::STATUS_DITOLAK)->count(),
            'kategori' => Kategori::count(),
        ];

        $antrean = Produk::where('status', Produk::STATUS_MENUNGGU)
            ->with(['kategori', 'user'])
            ->oldest()
            ->take(6)
            ->get();

        $perKategori = Kategori::query()
            ->withCount(['produk', 'produkDisetujui'])
            ->orderByDesc('produk_count')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('statistik', 'antrean', 'perKategori'));
    }
}
