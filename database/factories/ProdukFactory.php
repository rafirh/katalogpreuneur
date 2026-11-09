<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'kategori_id' => Kategori::factory(),
            'nama' => fake()->words(3, true),
            'deskripsi' => fake()->paragraph(),
            'harga' => fake()->numberBetween(10_000, 500_000),
            'stok' => fake()->numberBetween(0, 50),
            'foto' => null,
            'status' => Produk::STATUS_MENUNGGU,
            'alasan_penolakan' => null,
        ];
    }

    public function disetujui(): static
    {
        return $this->state(fn () => [
            'status' => Produk::STATUS_DISETUJUI,
            'alasan_penolakan' => null,
        ]);
    }

    public function ditolak(string $alasan = 'Foto tidak jelas.'): static
    {
        return $this->state(fn () => [
            'status' => Produk::STATUS_DITOLAK,
            'alasan_penolakan' => $alasan,
        ]);
    }
}
