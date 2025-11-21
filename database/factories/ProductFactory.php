<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $productNames = [
            'Kemeja Flanel Pria Premium',
            'Kaos Polos Cotton Combed 30s',
            'Hoodie Oversize Wanita',
            'Laptop ASUS Vivobook 14',
            'Mouse Logitech B170',
            'Keyboard Mechanical RGB',
            'Xiaomi Redmi Note 11',
            'Kipas Angin Portable USB',
        ];

        return [
            'seller_id'   => $this->faker->numberBetween(1, 5),
            'category_id' => $this->faker->numberBetween(1, 5),
            'nama_produk' => $this->faker->randomElement($productNames),
            'deskripsi'   => $this->faker->sentence(10),
            'harga'       => $this->faker->numberBetween(10000, 500000),
            'stok'        => $this->faker->numberBetween(1, 100),
            'gambar'      => null,
        ];
    }
}
