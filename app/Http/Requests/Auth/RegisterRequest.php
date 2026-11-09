<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => strtolower(trim((string) $this->email)),
            'whatsapp_number' => $this->normalizePhone((string) $this->whatsapp_number),
        ]);
    }

    private function normalizePhone(string $value): string
    {
        $digits = preg_replace('/\D+/', '', $value) ?? '';

        if (str_starts_with($digits, '62')) {
            $digits = '0'.substr($digits, 2);
        }

        return $digits;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
                'ends_with:@ub.ac.id',
            ],
            'whatsapp_number' => ['required', 'string', 'regex:/^08[0-9]{8,12}$/'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'email.ends_with' => 'Registrasi hanya untuk email resmi Universitas Brawijaya (@ub.ac.id).',
            'email.unique' => 'Email ini sudah terdaftar.',
            'whatsapp_number.regex' => 'Nomor WhatsApp harus berupa angka valid, diawali 08 (contoh: 081234567890).',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap',
            'email' => 'email',
            'whatsapp_number' => 'nomor WhatsApp',
            'password' => 'kata sandi',
        ];
    }
}
