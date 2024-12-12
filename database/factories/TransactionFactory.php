<?php

namespace Database\Factories;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'date' => fake()->dateTimeThisYear(),
      'amount' => fake()->numberBetween(20, 300),
      'type' => fake()->randomElement([
        TransactionType::Incoming,
        TransactionType::Reserved,
      ]),
    ];
  }
}
