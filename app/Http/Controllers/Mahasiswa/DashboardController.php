<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $ringkasan = [
            'total' => $user->produk()->count(),
            'disetujui' => $user->produk()->where('status', Produk::STATUS_DISETUJUI)->count(),
            'menunggu' => $user->produk()->where('status', Produk::STATUS_MENUNGGU)->count(),
            'ditolak' => $user->produk()->where('status', Produk::STATUS_DITOLAK)->count(),
        ];

        $terbaru = $user->produk()
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();

        $ditolak = $user->produk()
            ->where('status', Produk::STATUS_DITOLAK)
            ->latest()
            ->take(3)
            ->get();

        return view('mahasiswa.dashboard', compact('ringkasan', 'terbaru', 'ditolak'));
    }
}
