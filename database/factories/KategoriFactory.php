<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Kategori>
 */
class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    public function definition(): array
    {
        $nama = 'Kategori '.fake()->unique()->word();

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama).'-'.Str::random(4),
            'deskripsi' => fake()->sentence(),
        ];
    }
}
