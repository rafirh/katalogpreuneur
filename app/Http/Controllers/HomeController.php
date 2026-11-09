<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $kategori = Kategori::query()
            ->withCount('produkDisetujui')
            ->orderByDesc('produk_disetujui_count')
            ->orderBy('nama')
            ->take(6)
            ->get();

        $produkUnggulan = Produk::query()
            ->disetujui()
            ->with(['kategori', 'user'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        $statistik = [
            'produk' => Produk::disetujui()->count(),
            'penjual' => Produk::disetujui()->distinct('user_id')->count('user_id'),
            'kategori' => Kategori::count(),
        ];

        return view('public.home', compact('kategori', 'produkUnggulan', 'statistik'));
    }

    public function tentang(): View
    {
        return view('public.tentang');
    }
}
