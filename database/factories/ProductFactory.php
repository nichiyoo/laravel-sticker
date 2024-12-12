<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  private static int $counter = 1;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $id = $this->genearteId();
    return [
      'code' => $id,
      'name' => 'Sticker ' . $id,
      'description' => fake()->paragraph(3),
      'unit_of_measure' =>  'Pcs',
      'incoming' => fake()->numberBetween(0, 100),
      'reserved' => fake()->numberBetween(0, 100),
      'balance' => fake()->numberBetween(0, 100),
    ];
  }

  /**
   * Function to generate custom ID with format 10001
   * 
   * @return string result
   */
  public function genearteId(): string
  {
    return '1000' . self::$counter++;
  }
}
