<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Produk\StoreProdukRequest;
use App\Http\Requests\Produk\UpdateProdukRequest;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProdukController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $status = $request->query('status');

        $produk = $user->produk()
            ->with('kategori')
            ->when(in_array($status, Produk::STATUSES, true), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $ringkasan = [
            'total' => $user->produk()->count(),
            'disetujui' => $user->produk()->where('status', Produk::STATUS_DISETUJUI)->count(),
            'menunggu' => $user->produk()->where('status', Produk::STATUS_MENUNGGU)->count(),
            'ditolak' => $user->produk()->where('status', Produk::STATUS_DITOLAK)->count(),
        ];

        return view('mahasiswa.produk.index', compact('produk', 'ringkasan', 'status'));
    }

    public function create(): View
    {
        $kategori = Kategori::orderBy('nama')->get();

        return view('mahasiswa.produk.create', compact('kategori'));
    }

    public function store(StoreProdukRequest $request): RedirectResponse
    {
        $data = $request->safe()->only(['nama', 'kategori_id', 'deskripsi', 'harga', 'stok']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk = $request->user()->produk()->create([
            ...$data,
            'status' => Produk::STATUS_MENUNGGU,
            'alasan_penolakan' => null,
        ]);

        return redirect()
            ->route('mahasiswa.produk.index')
            ->with('status', "Produk \"{$produk->nama}\" berhasil dikirim dan menunggu verifikasi admin.");
    }

    public function show(Request $request, Produk $produk): View
    {
        Gate::authorize('view', $produk);
        $produk->load('kategori', 'user');

        return view('mahasiswa.produk.show', compact('produk'));
    }

    public function edit(Request $request, Produk $produk): View
    {
        Gate::authorize('update', $produk);
        $kategori = Kategori::orderBy('nama')->get();

        return view('mahasiswa.produk.edit', compact('produk', 'kategori'));
    }

    public function update(UpdateProdukRequest $request, Produk $produk): RedirectResponse
    {
        $data = $request->safe()->only(['nama', 'kategori_id', 'deskripsi', 'harga', 'stok']);

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        // An approved product that is edited must return to awaiting verification.
        $kembaliMenunggu = $produk->isDisetujui();

        $produk->update([
            ...$data,
            'status' => Produk::STATUS_MENUNGGU,
            'alasan_penolakan' => null,
        ]);

        $pesan = $kembaliMenunggu
            ? 'Perubahan disimpan. Karena produk sebelumnya telah disetujui, status dikembalikan ke menunggu verifikasi.'
            : 'Perubahan produk berhasil disimpan dan menunggu verifikasi ulang.';

        return redirect()
            ->route('mahasiswa.produk.index')
            ->with('status', $pesan);
    }

    public function destroy(Request $request, Produk $produk): RedirectResponse
    {
        Gate::authorize('delete', $produk);

        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $nama = $produk->nama;
        $produk->delete();

        return redirect()
            ->route('mahasiswa.produk.index')
            ->with('status', "Produk \"{$nama}\" telah dihapus.");
    }
}
