<?php

namespace App\Http\Requests\Produk;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isMahasiswa() === true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'harga' => $this->digitsOrNull($this->harga),
            'stok' => $this->digitsOrNull($this->stok),
            // Ownership is never taken from the request.
            'user_id' => $this->user()?->id,
            'status' => Produk::STATUS_MENUNGGU,
        ]);
    }

    private function digitsOrNull(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $raw = trim((string) $value);
        $negative = str_starts_with($raw, '-');
        $digits = preg_replace('/[^0-9]/', '', $raw);

        if ($digits === '') {
            return $value;
        }

        $number = (int) $digits;

        // Preserve negatives so validation rejects them instead of silently flipping the sign.
        return $negative ? -$number : $number;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:3', 'max:120'],
            'kategori_id' => [
                'required',
                Rule::exists('kategori', 'id'),
            ],
            'deskripsi' => ['required', 'string', 'min:20', 'max:5000'],
            'harga' => ['required', 'integer', 'min:0', 'max:999999999'],
            'stok' => ['required', 'integer', 'min:0', 'max:1000000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama produk wajib diisi.',
            'nama.min' => 'Nama produk minimal :min karakter.',
            'kategori_id.required' => 'Silakan pilih kategori.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal :min karakter agar pembeli mendapat gambaran jelas.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'foto.image' => 'Berkas harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 4 MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama produk',
            'kategori_id' => 'kategori',
            'deskripsi' => 'deskripsi',
            'harga' => 'harga',
            'stok' => 'stok',
            'foto' => 'foto produk',
        ];
    }
}
