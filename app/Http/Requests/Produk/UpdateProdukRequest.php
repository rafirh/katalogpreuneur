<?php

namespace App\Http\Requests\Produk;

use App\Models\Produk;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Produk|null $produk */
        $produk = $this->route('produk');

        // Enforce ownership on the server; a student may never edit others' products.
        return $produk !== null
            && $this->user()?->id === $produk->user_id;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'harga' => $this->digitsOrNull($this->harga),
            'stok' => $this->digitsOrNull($this->stok),
            // Ownership can never be reassigned through the request.
            'user_id' => $this->user()?->id,
        ]);
    }

    private function digitsOrNull(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $digits = preg_replace('/[^0-9]/', '', (string) $value);

        return $digits === '' ? $value : (int) $digits;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'min:3', 'max:120'],
            'kategori_id' => ['required', Rule::exists('kategori', 'id')],
            'deskripsi' => ['required', 'string', 'min:20', 'max:5000'],
            'harga' => ['required', 'integer', 'min:0', 'max:999999999'],
            'stok' => ['required', 'integer', 'min:0', 'max:1000000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
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
