<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;

class DashboardSellerControllerTest extends TestCase
{
    use RefreshDatabase;

    private function buatSellerDenganWilayah(): array
    {
        Province::firstOrCreate(['kode' => '35'], ['nama' => 'Jawa Timur']);
        Regency::firstOrCreate(['kode' => '3501'], ['province_kode' => '35', 'nama' => 'Lamongan']);
        District::firstOrCreate(['kode' => '350101'], ['regency_kode' => '3501', 'nama' => 'Lamongan']);

        $user   = User::factory()->create();
        $seller = Seller::factory()->create(['user_id' => $user->id]);

        return [$user, $seller];
    }

    /** @test */
    public function export_pdf_berhasil_jika_ada_produk_stok_kurang_dari_2()
    {
        [$user, $seller] = $this->buatSellerDenganWilayah();

        $category = Category::factory()->create();
        Product::factory()->create([
            'seller_id'   => $seller->id,
            'category_id' => $category->id,
            'stok'        => 1, // stok < 2, harus masuk laporan
        ]);

        $this->actingAs($user);

        $response = $this->get(route('seller.products.export.lowstock'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    /** @test */
    public function export_pdf_redirect_jika_tidak_ada_produk_stok_rendah()
    {
        [$user, $seller] = $this->buatSellerDenganWilayah();

        $category = Category::factory()->create();
        Product::factory()->create([
            'seller_id'   => $seller->id,
            'category_id' => $category->id,
            'stok'        => 10, // stok normal, tidak masuk filter
        ]);

        $this->actingAs($user);

        $response = $this->get(route('seller.products.export.lowstock'));
        $response->assertRedirect();
        $response->assertSessionHas('info');
    }
}