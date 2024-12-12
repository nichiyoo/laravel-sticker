<?php

namespace App\Filament\Resources\IncomingResource\Pages;

use App\Filament\Resources\IncomingResource;
use App\Enums\TransactionType;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Transaction;
use Filament\Notifications\Notification;

class EditIncoming extends EditRecord
{
  protected static string $resource = IncomingResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }

  protected function afterSave(): void
  {
    $product = $this->getRecord()->product;

    $product->incoming = Transaction::where('product_id', $product->id)->where('type', TransactionType::Incoming)->sum('amount');
    $product->reserved = Transaction::where('product_id', $product->id)->where('type', TransactionType::Reserved)->sum('amount');
    $product->balance = $product->incoming - $product->reserved;

    $product->save();
  }

  protected function getSavedNotification(): ?Notification
  {
    return Notification::make()
      ->success()
      ->title('Incoming Transaction Updated')
      ->body('Transaction has been updated successfully.');
  }
}
