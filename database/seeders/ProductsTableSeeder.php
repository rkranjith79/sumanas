<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $product = Product::create([
                'name' => $faker->name,
                'price' => $faker->randomFloat(2, 1, 100),
                'description' => $faker->sentence,
            ]);

            // Sync with Stripe
            $product->syncWithStripe();
        }
    }
}
