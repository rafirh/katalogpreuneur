<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProdukController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', Produk::STATUS_MENUNGGU);
        $q = trim((string) $request->query('q'));

        $produk = Produk::query()
            ->with(['kategori', 'user'])
            ->when(in_array($status, Produk::STATUSES, true), fn ($query) => $query->where('status', $status))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
                });
            })
            ->when($status === Produk::STATUS_MENUNGGU, fn ($query) => $query->oldest())
            ->when($status !== Produk::STATUS_MENUNGGU, fn ($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        $hitung = [
            'menunggu' => Produk::where('status', Produk::STATUS_MENUNGGU)->count(),
            'disetujui' => Produk::where('status', Produk::STATUS_DISETUJUI)->count(),
            'ditolak' => Produk::where('status', Produk::STATUS_DITOLAK)->count(),
        ];

        return view('admin.verifikasi.index', compact('produk', 'status', 'q', 'hitung'));
    }

    public function show(Produk $produk): View
    {
        $produk->load(['kategori', 'user']);

        return view('admin.verifikasi.show', compact('produk'));
    }

    public function approve(Request $request, Produk $produk): RedirectResponse
    {
        $produk->update([
            'status' => Produk::STATUS_DISETUJUI,
            'alasan_penolakan' => null,
        ]);

        return back()->with('status', "Produk \"{$produk->nama}\" telah disetujui dan kini tampil di katalog publik.");
    }

    public function reject(Request $request, Produk $produk): RedirectResponse
    {
        $data = $request->validate([
            'alasan_penolakan' => ['required', 'string', 'min:5', 'max:500'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.min' => 'Alasan penolakan minimal :min karakter.',
        ], [
            'alasan_penolakan' => 'alasan penolakan',
        ]);

        $produk->update([
            'status' => Produk::STATUS_DITOLAK,
            'alasan_penolakan' => $data['alasan_penolakan'],
        ]);

        return back()->with('status', "Produk \"{$produk->nama}\" ditolak. Alasan telah dicatat untuk penjual.");
    }
}
