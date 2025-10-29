<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories - Conventional Store
        $susu = Category::create([
            'name' => 'Susu & Dairy',
            'slug' => 'susu-dairy',
            'icon' => '🥛',
            'description' => 'Produk susu dan olahan susu',
            'is_active' => true,
        ]);

        $minuman = Category::create([
            'name' => 'Minuman',
            'slug' => 'minuman',
            'icon' => '🥤',
            'description' => 'Minuman segar dan soft drink',
            'is_active' => true,
        ]);

        $snack = Category::create([
            'name' => 'Snack & Makanan',
            'slug' => 'snack-makanan',
            'icon' => '�',
            'description' => 'Snack dan makanan ringan',
            'is_active' => true,
        ]);

        $kebutuhan = Category::create([
            'name' => 'Kebutuhan Rumah',
            'slug' => 'kebutuhan-rumah',
            'icon' => '🧺',
            'description' => 'Kebutuhan sehari-hari',
            'is_active' => true,
        ]);

        // Susu & Dairy Products
        Product::create([
            'category_id' => $susu->id,
            'name' => 'Ultra Milk Coklat 250ml',
            'slug' => 'ultra-milk-coklat-250ml',
            'description' => 'Susu UHT rasa coklat kemasan 250ml',
            'price' => 6500,
            'discount' => 15,
            'stock' => 85,
            'image' => 'ultra-milk-coklat.jpg',
            'sku' => 'SUS-001',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $susu->id,
            'name' => 'Indomilk Full Cream 250ml',
            'slug' => 'indomilk-full-cream-250ml',
            'description' => 'Susu UHT full cream 250ml',
            'price' => 6000,
            'discount' => 0,
            'stock' => 70,
            'image' => 'indomilk-full-cream.jpg',
            'sku' => 'SUS-002',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $susu->id,
            'name' => 'Frisian Flag Coklat 180ml',
            'slug' => 'frisian-flag-coklat-180ml',
            'description' => 'Susu steril rasa coklat 180ml',
            'price' => 5500,
            'discount' => 7,
            'stock' => 90,
            'image' => 'frisian-flag-coklat.jpg',
            'sku' => 'SUS-003',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $susu->id,
            'name' => 'Greenfields Strawberry 200ml',
            'slug' => 'greenfields-strawberry-200ml',
            'description' => 'Susu UHT rasa strawberry 200ml',
            'price' => 7000,
            'discount' => 0,
            'stock' => 45,
            'image' => 'greenfields-strawberry.jpg',
            'sku' => 'SUS-004',
            'is_active' => true,
        ]);

        // Minuman Products
        Product::create([
            'category_id' => $minuman->id,
            'name' => 'Coca Cola 390ml',
            'slug' => 'coca-cola-390ml',
            'description' => 'Minuman bersoda rasa cola 390ml',
            'price' => 6000,
            'discount' => 0,
            'stock' => 120,
            'image' => 'coca-cola-390ml.jpg',
            'sku' => 'MNM-001',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $minuman->id,
            'name' => 'Teh Pucuk Harum 350ml',
            'slug' => 'teh-pucuk-harum-350ml',
            'description' => 'Teh hijau rasa melati 350ml',
            'price' => 4500,
            'discount' => 3,
            'stock' => 150,
            'image' => 'teh-pucuk-harum.jpg',
            'sku' => 'MNM-002',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $minuman->id,
            'name' => 'Aqua 600ml',
            'slug' => 'aqua-600ml',
            'description' => 'Air mineral 600ml',
            'price' => 3500,
            'discount' => 0,
            'stock' => 200,
            'image' => 'aqua-600ml.jpg',
            'sku' => 'MNM-003',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $minuman->id,
            'name' => 'Fanta Orange 390ml',
            'slug' => 'fanta-orange-390ml',
            'description' => 'Minuman bersoda rasa jeruk 390ml',
            'price' => 6000,
            'discount' => 0,
            'stock' => 95,
            'image' => 'fanta-orange.jpg',
            'sku' => 'MNM-004',
            'is_active' => true,
        ]);

        // Snack & Makanan Products
        Product::create([
            'category_id' => $snack->id,
            'name' => 'Pocky Chocolate 47gr',
            'slug' => 'pocky-chocolate-47gr',
            'description' => 'Biskuit stick coklat premium 47gr',
            'price' => 13000,
            'discount' => 15,
            'stock' => 60,
            'image' => 'pocky-chocolate.jpg',
            'sku' => 'SNK-001',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $snack->id,
            'name' => 'Sial Olai 128gr',
            'slug' => 'sial-olai-128gr',
            'description' => 'Keripik kentang renyah 128gr',
            'price' => 11500,
            'discount' => 7,
            'stock' => 75,
            'image' => 'sial-olai.jpg',
            'sku' => 'SNK-002',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $snack->id,
            'name' => 'Chitato Sapi Panggang 68gr',
            'slug' => 'chitato-sapi-panggang-68gr',
            'description' => 'Keripik kentang rasa sapi panggang 68gr',
            'price' => 9500,
            'discount' => 0,
            'stock' => 85,
            'image' => 'chitato-sapi.jpg',
            'sku' => 'SNK-003',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $snack->id,
            'name' => 'Indomie Goreng',
            'slug' => 'indomie-goreng',
            'description' => 'Mi goreng instant rasa original',
            'price' => 3500,
            'discount' => 0,
            'stock' => 150,
            'image' => 'indomie-goreng.jpg',
            'sku' => 'SNK-004',
            'is_active' => true,
        ]);

        // Kebutuhan Rumah Products
        Product::create([
            'category_id' => $kebutuhan->id,
            'name' => 'Tisu Paseo 250 sheets',
            'slug' => 'tisu-paseo-250-sheets',
            'description' => 'Tissue wajah premium 250 lembar',
            'price' => 18500,
            'discount' => 3,
            'stock' => 40,
            'image' => 'tisu-paseo.jpg',
            'sku' => 'KBT-001',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $kebutuhan->id,
            'name' => 'Sunlight Lime 750ml',
            'slug' => 'sunlight-lime-750ml',
            'description' => 'Cairan pencuci piring lime 750ml',
            'price' => 15000,
            'discount' => 0,
            'stock' => 55,
            'image' => 'sunlight-lime.jpg',
            'sku' => 'KBT-002',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $kebutuhan->id,
            'name' => 'Molto Ultra Sekali Bilas 900ml',
            'slug' => 'molto-ultra-sekali-bilas-900ml',
            'description' => 'Pelembut pakaian sekali bilas 900ml',
            'price' => 12500,
            'discount' => 7,
            'stock' => 35,
            'image' => 'molto-ultra.jpg',
            'sku' => 'KBT-003',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $kebutuhan->id,
            'name' => 'Mama Lemon 800ml',
            'slug' => 'mama-lemon-800ml',
            'description' => 'Cairan pencuci piring lemon 800ml',
            'price' => 14000,
            'discount' => 0,
            'stock' => 48,
            'image' => 'mama-lemon.jpg',
            'sku' => 'KBT-004',
            'is_active' => true,
        ]);

        $this->command->info('✅ Conventional store categories and products created successfully!');
    }
}
