<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    User::factory()->create([
      'name' => 'Administrator',
      'email' => 'admin@example.com',
    ]);

    // $products = Product::factory()->count(20)->create();
    // $products->each(function ($product) {
    //   Transaction::factory()->count(5)->create([
    //     'product_id' => $product->id,
    //   ]);
    // });

    $products = Product::factory()->count(20)->create([
      'incoming' => 0,
      'reserved' => 0,
      'balance' => 0,
    ]);
  }
}
