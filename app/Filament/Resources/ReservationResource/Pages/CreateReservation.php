<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Enums\TransactionType;
use App\Filament\Resources\ReservationResource;
use App\Models\Transaction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateReservation extends CreateRecord
{
  protected static string $resource = ReservationResource::class;

  protected function afterCreate(): void
  {
    $product = $this->getRecord()->product;

    $product->incoming = Transaction::where('product_id', $product->id)->where('type', TransactionType::Incoming)->sum('amount');
    $product->reserved = Transaction::where('product_id', $product->id)->where('type', TransactionType::Reserved)->sum('amount');
    $product->balance = $product->incoming - $product->reserved;

    $product->save();
  }

  protected function getCreatedNotification(): ?Notification
  {
    return Notification::make()
      ->success()
      ->title('Reservation Created')
      ->body('Transaction has been created successfully.');
  }
}
