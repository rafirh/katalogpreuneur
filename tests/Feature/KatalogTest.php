<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_approved_products_are_listed(): void
    {
        $approved = Produk::factory()->disetujui()->create(['nama' => 'Produk Disetujui']);
        Produk::factory()->create(['nama' => 'Produk Menunggu', 'status' => Produk::STATUS_MENUNGGU]);
        Produk::factory()->ditolak()->create(['nama' => 'Produk Ditolak']);

        $response = $this->get(route('katalog.index'));

        $response->assertOk();
        $response->assertSee('Produk Disetujui');
        $response->assertDontSee('Produk Menunggu');
        $response->assertDontSee('Produk Ditolak');
    }

    public function test_pending_product_detail_returns_404(): void
    {
        $produk = Produk::factory()->create(['status' => Produk::STATUS_MENUNGGU]);

        $this->get(route('katalog.show', $produk))->assertNotFound();
    }

    public function test_rejected_product_detail_returns_404(): void
    {
        $produk = Produk::factory()->ditolak()->create();

        $this->get(route('katalog.show', $produk))->assertNotFound();
    }

    public function test_approved_product_detail_is_accessible(): void
    {
        $produk = Produk::factory()->disetujui()->create(['nama' => 'Produk Publik']);

        $this->get(route('katalog.show', $produk))->assertOk()->assertSee('Produk Publik');
    }

    public function test_search_filters_products(): void
    {
        Produk::factory()->disetujui()->create(['nama' => 'Kopi Susu Spesial']);
        Produk::factory()->disetujui()->create(['nama' => 'Batik Tulis']);

        $response = $this->get(route('katalog.index', ['q' => 'Kopi']));

        $response->assertSee('Kopi Susu Spesial');
        $response->assertDontSee('Batik Tulis');
    }

    public function test_category_filter_works(): void
    {
        $kategoriA = Kategori::factory()->create(['nama' => 'Kuliner']);
        $kategoriB = Kategori::factory()->create(['nama' => 'Fashion']);
        Produk::factory()->disetujui()->create(['nama' => 'Makanan Enak', 'kategori_id' => $kategoriA->id]);
        Produk::factory()->disetujui()->create(['nama' => 'Kaos Keren', 'kategori_id' => $kategoriB->id]);

        $response = $this->get(route('katalog.index', ['kategori' => $kategoriA->slug]));

        $response->assertSee('Makanan Enak');
        $response->assertDontSee('Kaos Keren');
    }

    public function test_whatsapp_order_link_is_generated_correctly(): void
    {
        $seller = User::factory()->create(['name' => 'Penjual Uji', 'whatsapp_number' => '081234567890']);
        $produk = Produk::factory()->disetujui()->for($seller)->create(['nama' => 'Produk WA']);

        $url = $produk->whatsappOrderUrl();

        $this->assertStringStartsWith('https://wa.me/6281234567890?text=', $url);
        $this->assertStringContainsString(rawurlencode('Produk WA'), $url);
    }

    public function test_home_page_loads(): void
    {
        Produk::factory()->disetujui()->count(3)->create();

        $this->get(route('home'))->assertOk()->assertSee('Temukan Produk');
    }
}
