<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->to($this->homeFor(Auth::user()));
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Kombinasi email dan kata sandi tidak cocok.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended($this->homeFor(Auth::user()))
            ->with('status', 'Selamat datang kembali, '.Auth::user()->name.'.');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->to($this->homeFor(Auth::user()));
        }

        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_MAHASISWA,
            'whatsapp_number' => $data['whatsapp_number'],
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('mahasiswa.dashboard')
            ->with('status', 'Akun penjual berhasil dibuat. Selamat berjualan!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Anda telah keluar.');
    }

    private function homeFor(?User $user): string
    {
        return $user?->isAdmin()
            ? route('admin.dashboard')
            : route('mahasiswa.dashboard');
    }
}
