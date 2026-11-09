<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProdukTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(Kategori $kategori, array $overrides = []): array
    {
        return array_merge([
            'nama' => 'Produk Uji Coba',
            'kategori_id' => $kategori->id,
            'deskripsi' => 'Deskripsi produk yang cukup panjang untuk lolos validasi.',
            'harga' => 25000,
            'stok' => 10,
        ], $overrides);
    }

    public function test_mahasiswa_can_create_product_with_pending_status(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $kategori = Kategori::factory()->create();

        $response = $this->actingAs($user)->post(route('mahasiswa.produk.store'), $this->validPayload($kategori, [
            'foto' => UploadedFile::fake()->image('foto.jpg'),
        ]));

        $response->assertRedirect(route('mahasiswa.produk.index'));
        $this->assertDatabaseHas('produk', [
            'user_id' => $user->id,
            'nama' => 'Produk Uji Coba',
            'status' => Produk::STATUS_MENUNGGU,
        ]);
    }

    public function test_new_product_ignores_injected_status_and_owner(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $kategori = Kategori::factory()->create();

        $this->actingAs($user)->post(route('mahasiswa.produk.store'), $this->validPayload($kategori, [
            'status' => Produk::STATUS_DISETUJUI,
            'user_id' => $other->id,
        ]));

        $produk = Produk::first();
        $this->assertSame(Produk::STATUS_MENUNGGU, $produk->status);
        $this->assertSame($user->id, $produk->user_id);
    }

    public function test_product_validation_rejects_negative_price_and_stock(): void
    {
        $user = User::factory()->create();
        $kategori = Kategori::factory()->create();

        $this->actingAs($user)->post(route('mahasiswa.produk.store'), $this->validPayload($kategori, [
            'harga' => -100,
            'stok' => -5,
        ]))->assertSessionHasErrors(['harga', 'stok']);

        $this->assertDatabaseCount('produk', 0);
    }

    public function test_student_can_update_own_product(): void
    {
        $user = User::factory()->create();
        $produk = Produk::factory()->for($user)->create(['status' => Produk::STATUS_MENUNGGU]);

        $this->actingAs($user)->put(route('mahasiswa.produk.update', $produk), $this->validPayload($produk->kategori, [
            'nama' => 'Nama Baru',
        ]))->assertRedirect(route('mahasiswa.produk.index'));

        $this->assertDatabaseHas('produk', ['id' => $produk->id, 'nama' => 'Nama Baru']);
    }

    public function test_student_cannot_update_another_students_product(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $produk = Produk::factory()->for($owner)->create();

        $this->actingAs($intruder)->put(route('mahasiswa.produk.update', $produk), $this->validPayload($produk->kategori, [
            'nama' => 'Hacked',
        ]))->assertForbidden();

        $this->assertDatabaseMissing('produk', ['id' => $produk->id, 'nama' => 'Hacked']);
    }

    public function test_editing_approved_product_resets_status_to_pending(): void
    {
        $user = User::factory()->create();
        $produk = Produk::factory()->for($user)->create(['status' => Produk::STATUS_DISETUJUI]);

        $this->actingAs($user)->put(route('mahasiswa.produk.update', $produk), $this->validPayload($produk->kategori, [
            'nama' => 'Diedit',
        ]));

        $this->assertSame(Produk::STATUS_MENUNGGU, $produk->fresh()->status);
    }

    public function test_student_can_delete_own_product(): void
    {
        $user = User::factory()->create();
        $produk = Produk::factory()->for($user)->create();

        $this->actingAs($user)->delete(route('mahasiswa.produk.destroy', $produk))
            ->assertRedirect(route('mahasiswa.produk.index'));

        $this->assertDatabaseMissing('produk', ['id' => $produk->id]);
    }

    public function test_student_cannot_delete_another_students_product(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $produk = Produk::factory()->for($owner)->create();

        $this->actingAs($intruder)->delete(route('mahasiswa.produk.destroy', $produk))->assertForbidden();

        $this->assertDatabaseHas('produk', ['id' => $produk->id]);
    }

    public function test_guest_cannot_access_student_dashboard(): void
    {
        $this->get(route('mahasiswa.dashboard'))->assertRedirect(route('login'));
    }
}
