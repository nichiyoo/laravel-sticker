<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;


enum TransactionType: string implements HasColor, HasIcon, HasLabel
{
  case Incoming = 'Incoming';
  case Reserved = 'Reserved';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::Incoming => 'Incoming',
      self::Reserved => 'Reserved',
    };
  }

  public function getColor(): string | array | null
  {
    return match ($this) {
      self::Incoming => 'info',
      self::Reserved => 'warning',
    };
  }

  public function getIcon(): ?string
  {
    return match ($this) {
      self::Incoming => 'heroicon-o-truck',
      self::Reserved => 'heroicon-o-shopping-bag',
    };
  }
}
