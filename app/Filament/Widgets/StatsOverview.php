<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Transaction;
use App\Enums\TransactionType;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{

  protected function getHeading(): ?string
  {
    return 'Products Overview';
  }

  protected function getDescription(): ?string
  {
    return 'An overview of all the products in the system.';
  }

  protected function getStats(): array
  {
    $total = Product::count();
    $incoming = Transaction::where('type', TransactionType::Incoming)->sum('amount');
    $reserved = Transaction::where('type', TransactionType::Reserved)->sum('amount');

    return [
      Stat::make('Total Products', $total)
        ->description('Number of products in the system')
        ->descriptionIcon('heroicon-o-archive-box', \Filament\Support\Enums\IconPosition::Before),

      Stat::make('Incoming Transactions', $incoming)
        ->description('Number of incoming transactions')
        ->descriptionIcon('heroicon-o-credit-card', \Filament\Support\Enums\IconPosition::Before),

      Stat::make('Reserved Transactions', $reserved)
        ->description('Number of reserved transactions')
        ->descriptionIcon('heroicon-o-shopping-bag', \Filament\Support\Enums\IconPosition::Before),
    ];
  }
}
