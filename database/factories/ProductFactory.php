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
        1 => [ // ELEKTRONIK
            ['Laptop ASUS Vivobook 14', 7500000],
            ['Mouse Logitech B170', 120000],
            ['Keyboard Mechanical RGB', 350000],
            ['Xiaomi Redmi Note 11', 2300000],
            ['Kipas Angin Portable USB', 50000],
            ['Laptop ACER Swift 3', 13000000],

            // Tambahan banyak elektronik
            ['TV LED Samsung 32 Inch', 2300000],
            ['Smartwatch Amazfit Bip U', 550000],
            ['Earphone Baseus Encok', 150000],
            ['Charger Anker 20W Fast Charging', 180000],
            ['Powerbank Xiaomi 20.000mAh', 350000],
            ['Laptop Lenovo Ideapad Slim 3', 8200000],
            ['Bluetooth Speaker JBL Go 3', 450000],
            ['Webcam Logitech C270', 350000],
            ['Printer Epson L3150', 2700000],
            ['Monitor LG 24 Inch IPS', 1450000],
            ['Tablet Samsung Galaxy Tab A7', 2999000],
            ['Flashdisk Sandisk 64GB', 90000],
            ['Harddisk External WD 1TB', 700000],
            ['Router TP-Link WR840N', 160000],
            ['Keyboard Wireless Logitech K230', 180000],
            ['Headset Rexus Vonix F30', 120000],
        ],

        2 => [ // FASHION
            ['Kemeja Flanel Pria Premium', 120000],
            ['Kaos Polos Cotton Combed 30s', 45000],
            ['Hoodie Oversize Wanita', 150000],
            ['Baggy Jeans Wanita', 75000],
            ['Pashmina Kaos', 45000],

            // Tambahan banyak fashion
            ['Sweater Rajut Wanita', 89000],
            ['Cardigan Knit Oversize', 130000],
            ['Celana Cargo Pria', 120000],
            ['Rok Plisket Premium', 80000],
            ['Jaket Bomber Pria', 150000],
            ['Blouse Wanita Korea Style', 95000],
            ['Setelan Training Pria', 110000],
            ['Sandal Flat Wanita', 35000],
            ['Kemeja Linen Pria', 130000],
            ['Kaos Distro Premium', 65000],
            ['Dress Wanita Casual', 140000],
            ['Hijab Voal Premium', 55000],
            ['Sepatu Slip-On Wanita', 85000],
            ['Kacamata Hitam Fashion', 30000],
        ],

        3 => [ // KECANTIKAN
            ['Serum Niacinamide 10% Some by Me', 70000],
            ['Facial Wash Gentle Cleanser Azarine', 35000],
            ['Sunscreen SPF 50+ Wardah', 55000],
            ['Micelar Water Glad2Glow', 40000],
            ['Cushion Instaperfect', 135000],
            ['Mascara Barenbliss', 60000],
            ['Lip Stain Timephoria', 150000],

            // Tambahan kecantikan
            ['Toner Exfoliating Avoskin', 99000],
            ['Day Cream Scarlett Brightly', 78000],
            ['Night Cream Scarlett Brightly', 80000],
            ['Facial Wash Emina Bright Stuff', 25000],
            ['Clay Mask MS Glow', 78000],
            ['Lip Balm Vaseline Stick', 18000],
            ['Aloe Vera Gel Nature Republic', 55000],
            ['Perfume Zara Femme', 250000],
            ['BB Cream Maybelline', 65000],
            ['Serum Vitamin C Garnier', 65000],
            ['Foundation Wardah Luminous', 60000],
            ['Makeup Remover Nivea', 35000],
        ],

        4 => [ // RUMAH TANGGA
            ['Air Fryer 4 Liter Low Watt', 650000],
            ['Panci Anti Lengket 24cm', 120000],
            ['Pisau Dapur Set Stainless 5 pcs', 85000],
            ['Setrika Cosmos', 90000],
            ['Kipas Angin Cosmos', 200000],
            ['AC LG', 4000000],

            // Tambahan rumah tangga
            ['Set Sapu dan Pengki', 25000],
            ['Tempat Sampah Stainless', 45000],
            ['Rak Sepatu 5 Susun', 85000],
            ['Dispenser Miyako', 280000],
            ['Kompor Gas Quantum', 350000],
            ['Rak Dapur Serbaguna', 110000],
            ['Piring Keramik 6 pcs', 65000],
            ['Gelas Kaca 6 pcs', 30000],
            ['Selimut Bulu Lembut', 75000],
            ['Keset Karet Anti Slip', 20000],
            ['Sapu Lantai Super', 15000],
        ],

        5 => [ // OLAHRAGA
            ['Sepatu Sneaker Training', 250000],
            ['Matras Yoga Premium', 90000],
            ['Botol Minum Sport 1 Liter', 30000],
            ['Raket Padel', 300000],

            // Tambahan olahraga
            ['Sarung Tangan Gym', 60000],
            ['Bola Futsal Adidas', 190000],
            ['Speed Rope Jump Rope', 35000],
            ['Knee Support', 55000],
            ['Gym Bag Waterproof', 75000],
            ['Dumbbell 2kg', 65000],
            ['Sepeda Lipat Element', 3300000],
            ['Baju Training Sport', 85000],
            ['Headband Sport', 20000],
            ['Tas Raket Badminton', 90000],
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
            ],
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
