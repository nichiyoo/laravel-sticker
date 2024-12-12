<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  /**
   * The attributes that are not mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'incoming' => 'integer',
    'reserved' => 'integer',
    'balance' => 'integer',
  ];

  /**
   * Get the transactions for the product.
   */
  public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Transaction::class);
  }
}
