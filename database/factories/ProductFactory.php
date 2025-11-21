<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        // Produk per kategori (nama + harga)
        $productsByCategory = [
            1 => [ // Elektronik
                ['Laptop ASUS Vivobook 14', 7500000],
                ['Mouse Logitech B170', 120000],
                ['Keyboard Mechanical RGB', 350000],
                ['Xiaomi Redmi Note 11', 2300000],
                ['Kipas Angin Portable USB', 50000],
                ['Laptop ACER Swift 3', 13000000],
            ],
            2 => [ // Fashion
                ['Kemeja Flanel Pria Premium', 120000],
                ['Kaos Polos Cotton Combed 30s', 45000],
                ['Hoodie Oversize Wanita', 150000],
                ['Baggy Jeans Wanita', 75000],
                ['Pashmina Kaos', 45000],
            ],
            3 => [ // Kecantikan
                ['Serum Niacinamide 10% Some by Me', 70000],
                ['Facial Wash Gentle Cleanser Azarine', 35000],
                ['Sunscreen SPF 50+ Wardah', 55000],
                ['Micelar Water Glad2Glow', 40000],
                ['Cushion Instaperfect', 135000],
                ['Mascara Barenbliss', 60000],
                ['Lip Stain Timephoria', 150000],
            ],
            4 => [ // Rumah Tangga
                ['Air Fryer 4 Liter Low Watt', 650000],
                ['Panci Anti Lengket 24cm', 120000],
                ['Pisau Dapur Set Stainless 5 pcs', 85000],
                ['Setrika Cosmos', 90000],
                ['Kipas Angin Cosmos', 200000],
                ['AC LG', 4000000],
            ],
            5 => [ // Olahraga
                ['Sepatu Sneaker Training', 250000],
                ['Matras Yoga Premium', 90000],
                ['Botol Minum Sport 1 Liter', 30000],
                ['Raket Padel', 300000],
            ],
        ];

        // Ambil kategori
        $category_id = $this->faker->numberBetween(1, 5);
        $product = $this->faker->randomElement($productsByCategory[$category_id]);

        // Deskripsi per kategori
        $descriptionTemplates = [
            1 => [
                "Produk elektronik berkualitas dengan fitur modern dan performa stabil. Dirancang untuk penggunaan harian maupun pekerjaan profesional.",
                "Hadir dengan desain ringan dan daya tahan tinggi, cocok untuk belajar, bekerja, maupun hiburan.",
                "Dilengkapi teknologi terbaru untuk memberikan pengalaman penggunaan yang cepat dan responsif."
            ],
            2 => [
                "Bahan nyaman dan adem, cocok digunakan sehari-hari dengan berbagai aktivitas.",
                "Desain stylish yang mudah dipadukan dengan berbagai outfit.",
                "Menggunakan material premium yang lembut dan tidak panas di kulit."
            ],
            3 => [
                "Formula lembut dan aman digunakan setiap hari. Cocok untuk semua jenis kulit.",
                "Membantu menjaga kelembapan kulit sekaligus menutrisi secara optimal.",
                "Diperkaya dengan bahan aktif yang efektif merawat kulit tanpa iritasi."
            ],
            4 => [
                "Peralatan rumah tangga praktis dengan material kuat dan tahan lama.",
                "Membantu mempermudah kegiatan memasak dan pekerjaan rumah lainnya.",
                "Desain ergonomis dan mudah dibersihkan, cocok untuk kebutuhan rumah modern."
            ],
            5 => [
                "Perlengkapan olahraga dengan kualitas terbaik untuk mendukung aktivitas fisik.",
                "Nyaman digunakan dan memiliki daya tahan tinggi untuk latihan rutin.",
                "Dirancang agar ringan, kuat, dan membantu meningkatkan performa olahraga."
            ]
        ];

        $description = $this->faker->randomElement($descriptionTemplates[$category_id]);

        return [
            'seller_id'   => $this->faker->numberBetween(1, 30),
            'category_id' => $category_id,
            'nama_produk' => $product[0],
            'deskripsi'   => $description,
            'harga'       => $product[1],
            'stok'        => $this->faker->numberBetween(5, 200),
            'gambar'      => 'default.jpg',
        ];
    }
}
