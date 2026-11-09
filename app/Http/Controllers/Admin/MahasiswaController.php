<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $mahasiswa = User::query()
            ->where('role', User::ROLE_MAHASISWA)
            ->withCount([
                'produk',
                'produk as produk_disetujui_count' => fn ($q2) => $q2->where('status', 'disetujui'),
            ])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.mahasiswa.index', compact('mahasiswa', 'q'));
    }
}
