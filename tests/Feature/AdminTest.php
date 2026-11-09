<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_product_and_clear_rejection_reason(): void
    {
        $admin = User::factory()->admin()->create();
        $produk = Produk::factory()->ditolak('Alasan lama')->create();

        $this->actingAs($admin)->patch(route('admin.verifikasi.approve', $produk))
            ->assertRedirect();

        $produk->refresh();
        $this->assertSame(Produk::STATUS_DISETUJUI, $produk->status);
        $this->assertNull($produk->alasan_penolakan);
    }

    public function test_admin_can_reject_product_with_reason(): void
    {
        $admin = User::factory()->admin()->create();
        $produk = Produk::factory()->create(['status' => Produk::STATUS_MENUNGGU]);

        $this->actingAs($admin)->patch(route('admin.verifikasi.reject', $produk), [
            'alasan_penolakan' => 'Foto produk terlalu gelap.',
        ])->assertRedirect();

        $produk->refresh();
        $this->assertSame(Produk::STATUS_DITOLAK, $produk->status);
        $this->assertSame('Foto produk terlalu gelap.', $produk->alasan_penolakan);
    }

    public function test_admin_cannot_reject_without_reason(): void
    {
        $admin = User::factory()->admin()->create();
        $produk = Produk::factory()->create(['status' => Produk::STATUS_MENUNGGU]);

        $this->actingAs($admin)->patch(route('admin.verifikasi.reject', $produk), [
            'alasan_penolakan' => '',
        ])->assertSessionHasErrors('alasan_penolakan');

        $this->assertSame(Produk::STATUS_MENUNGGU, $produk->fresh()->status);
    }

    public function test_non_admin_cannot_access_admin_verification(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.verifikasi.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admin_can_create_category(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.kategori.store'), [
            'nama' => 'Kuliner Nusantara',
            'deskripsi' => 'Makanan khas.',
        ])->assertRedirect(route('admin.kategori.index'));

        $this->assertDatabaseHas('kategori', ['nama' => 'Kuliner Nusantara']);
    }

    public function test_admin_can_update_category(): void
    {
        $admin = User::factory()->admin()->create();
        $kategori = Kategori::factory()->create(['nama' => 'Lama']);

        $this->actingAs($admin)->put(route('admin.kategori.update', $kategori), [
            'nama' => 'Fashion Baru',
        ])->assertRedirect(route('admin.kategori.index'));

        $this->assertDatabaseHas('kategori', ['id' => $kategori->id, 'nama' => 'Fashion Baru']);
    }

    public function test_admin_cannot_delete_category_with_products(): void
    {
        $admin = User::factory()->admin()->create();
        $kategori = Kategori::factory()->create();
        Produk::factory()->create(['kategori_id' => $kategori->id]);

        $this->actingAs($admin)->delete(route('admin.kategori.destroy', $kategori))
            ->assertRedirect(route('admin.kategori.index'));

        $this->assertDatabaseHas('kategori', ['id' => $kategori->id]);
    }

    public function test_admin_can_delete_empty_category(): void
    {
        $admin = User::factory()->admin()->create();
        $kategori = Kategori::factory()->create();

        $this->actingAs($admin)->delete(route('admin.kategori.destroy', $kategori))
            ->assertRedirect(route('admin.kategori.index'));

        $this->assertDatabaseMissing('kategori', ['id' => $kategori->id]);
    }
}
