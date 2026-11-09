<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('mahasiswa.profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'whatsapp_number' => ['required', 'string', 'regex:/^08[0-9]{8,12}$/'],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'whatsapp_number.regex' => 'Nomor WhatsApp harus berupa angka valid, diawali 08 (contoh: 081234567890).',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ], [
            'name' => 'nama lengkap',
            'whatsapp_number' => 'nomor WhatsApp',
            'password' => 'kata sandi',
        ]);

        $user->name = $data['name'];
        $user->whatsapp_number = $data['whatsapp_number'];

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return redirect()
            ->route('mahasiswa.profile.edit')
            ->with('status', 'Profil berhasil diperbarui.');
    }
}
