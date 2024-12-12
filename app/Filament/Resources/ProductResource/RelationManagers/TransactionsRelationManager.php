<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Filament\Resources\TransactionResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
  protected static string $relationship = 'transactions';

  public function form(Form $form): Form
  {
    return TransactionResource::form($form);
  }

  public function table(Table $table): Table
  {
    return TransactionResource::table($table)
      ->headerActions([
        Tables\Actions\CreateAction::make(),
      ])
      ->actions([
        Tables\Actions\DeleteAction::make(),
      ])
      ->groupedBulkActions([
        Tables\Actions\DeleteBulkAction::make(),
      ]);
  }
}
