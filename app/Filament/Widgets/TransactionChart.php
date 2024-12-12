<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionType;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TransactionChart extends ChartWidget
{
  protected static ?string $heading = 'Transaction Chart';
  protected int | string | array $columnSpan = 'full';

  protected static ?int $sort = 2;


  protected function getType(): string
  {
    return 'line';
  }

  protected function getData(): array
  {
    $incoming = Trend::query(Transaction::where('type', TransactionType::Incoming))
      ->dateColumn('date')
      ->between(
        start: now()->startOfYear(),
        end: now()->endOfYear(),
      )
      ->perMonth()
      ->sum('amount');

    $reserved = Trend::query(Transaction::where('type', TransactionType::Reserved))
      ->dateColumn('date')
      ->between(
        start: now()->startOfYear(),
        end: now()->endOfYear(),
      )
      ->perMonth()
      ->sum('amount');

    return [
      'datasets' => [
        [
          'label' => 'Incomings',
          'data' => $incoming->map(fn(TrendValue $value) => $value->aggregate),
          'tension' => 0.4,
          'borderColor' => '#00b894',
        ],
        [
          'label' => 'Reserved',
          'data' => $reserved->map(fn(TrendValue $value) => $value->aggregate),
          'tension' => 0.4,
        ]
      ],
      'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    ];
  }
}
