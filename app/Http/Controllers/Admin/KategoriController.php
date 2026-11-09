<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kategori\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategori = Kategori::query()
            ->withCount('produk')
            ->orderBy('nama')
            ->get();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(KategoriRequest $request): RedirectResponse
    {
        $kategori = Kategori::create($request->validated());

        return redirect()
            ->route('admin.kategori.index')
            ->with('status', "Kategori \"{$kategori->nama}\" berhasil ditambahkan.");
    }

    public function update(KategoriRequest $request, Kategori $kategori): RedirectResponse
    {
        $kategori->update($request->validated());

        return redirect()
            ->route('admin.kategori.index')
            ->with('status', "Kategori \"{$kategori->nama}\" berhasil diperbarui.");
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        if ($kategori->produk()->exists()) {
            return redirect()
                ->route('admin.kategori.index')
                ->with('error', "Kategori \"{$kategori->nama}\" tidak dapat dihapus karena masih memiliki produk terkait.");
        }

        $nama = $kategori->nama;
        $kategori->delete();

        return redirect()
            ->route('admin.kategori.index')
            ->with('status', "Kategori \"{$nama}\" berhasil dihapus.");
    }
}
