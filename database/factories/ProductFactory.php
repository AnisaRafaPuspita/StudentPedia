<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
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
            'Air Fryer 4 Liter Low Watt',
            'Sepatu Sneaker Casual Putih',
            'Tas Ransel Laptop Waterproof',
            'Jam Tangan Sport Digital',
            'Charger Fast Charging 20W',
            'Earphone Bluetooth TWS',
            'Powerbank 10000mAh Real Capacity',
            'Beras Premium Pandan Wangi 5KG',
            'Minyak Goreng Sawit 1 Liter',
            'Madu Hutan Asli 250ml',
            'Skincare Serum Niacinamide 10%',
            'Face Wash Gentle Cleanser',
            'Kotak Makan Stainless Anti Bocor',
            'Botol Minum 1 Liter BPA Free',
            'Panci Anti Lengket 24cm',
            'Pisau Dapur Stainless Set 5 pcs',
            'Mainan Anak Puzzle Kayu',
            'Boneka Teddy 40cm',
            'Baby Blanket Halus Premium',
            'Lampu LED Emergency Rechargeable',
            'Buku Catatan Hardcover A5',
            'Pulpen Gel Hitam 0.5mm',
        ];

        return [
            'seller_id'   => $this->faker->numberBetween(1, 30),
            'category_id' => $this->faker->numberBetween(1, 6), // sesuai CategorySeeder
            'nama_produk' => $this->faker->randomElement($productNames),
            'deskripsi'   => $this->faker->paragraph(3),
            'harga'       => $this->faker->numberBetween(15000, 5000000),
            'stok'        => $this->faker->numberBetween(5, 200),
            'gambar'      => null, // bisa di-update nanti
        ];
    }
}
