<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));
        $kategoriSlug = $request->query('kategori');
        $urut = (string) $request->query('urut', 'terbaru');

        $kategoriAktif = null;
        if ($kategoriSlug) {
            $kategoriAktif = Kategori::where('slug', $kategoriSlug)->first();
        }

        $produk = Produk::query()
            ->disetujui()
            ->with(['kategori', 'user'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
                });
            })
            ->when($kategoriAktif, fn ($query) => $query->where('kategori_id', $kategoriAktif->id))
            ->when($urut === 'termurah', fn ($query) => $query->orderBy('harga'))
            ->when($urut === 'termahal', fn ($query) => $query->orderByDesc('harga'))
            ->when($urut === 'terbaru', fn ($query) => $query->latest())
            ->paginate(12)
            ->withQueryString();

        $kategori = Kategori::query()
            ->withCount('produkDisetujui')
            ->orderBy('nama')
            ->get();

        return view('public.katalog', [
            'produk' => $produk,
            'kategori' => $kategori,
            'kategoriAktif' => $kategoriAktif,
            'q' => $q,
            'urut' => $urut,
            'total' => $produk->total(),
        ]);
    }

    public function show(Produk $produk): View
    {
        // Only approved products are ever visible to the public.
        abort_unless($produk->isDisetujui(), 404);

        $produk->load(['kategori', 'user']);

        $terkait = Produk::query()
            ->disetujui()
            ->where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->with(['kategori', 'user'])
            ->latest()
            ->take(4)
            ->get();

        return view('public.produk-detail', compact('produk', 'terkait'));
    }
}
