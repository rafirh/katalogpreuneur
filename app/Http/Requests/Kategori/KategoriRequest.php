<?php

namespace App\Http\Requests\Kategori;

use App\Models\Kategori;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    public function rules(): array
    {
        /** @var Kategori|null $kategori */
        $kategori = $this->route('kategori');

        return [
            'nama' => [
                'required',
                'string',
                'min:2',
                'max:60',
                Rule::unique('kategori', 'nama')->ignore($kategori?->id),
            ],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'ikon' => ['nullable', 'string', 'max:40'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama kategori',
            'deskripsi' => 'deskripsi',
        ];
    }
}
