<?php

namespace App\Models;

use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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
   * @var array<string, string>
   */
  protected function casts(): array
  {
    return [
      'date' => 'date',
      'amount' => 'integer',
      'type' => TransactionType::class,
    ];
  }

  /**
   * Get the product for the transaction.
   */
  public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Product::class);
  }
}
