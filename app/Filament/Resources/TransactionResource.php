<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use App\Enums\TransactionType;
use Filament\Resources\Resource;
use App\Filament\Resources\TransactionResource\Pages;

class TransactionResource extends Resource
{
  protected static ?string $model = Transaction::class;
  protected static ?string $navigationGroup = 'Transaction Management';
  protected static ?string $navigationIcon = 'heroicon-o-credit-card';
  protected static ?int $navigationSort = 1;

  public static function getModelLabel(): string
  {
    return __('Transaction');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('product_id')
          ->label('Product')
          ->relationship(name: 'product', titleAttribute: 'name')
          ->createOptionForm([
            Forms\Components\TextInput::make('code')
              ->label('Code Material')
              ->validationAttribute('Code Material')
              ->placeholder('Code Material')
              ->required()
              ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('unit_of_measure')
              ->label('Unit of Measure')
              ->validationAttribute('Unit of Measure')
              ->placeholder('Unit of Measure')
              ->prefixIcon('heroicon-o-scale')
              ->required()
              ->default('kg'),

            Forms\Components\TextInput::make('name')
              ->label('Name')
              ->validationAttribute('Name')
              ->placeholder('Name')
              ->required()
              ->columnSpan('full'),

            Forms\Components\FileUpload::make('image')
              ->label('Image')
              ->validationAttribute('Image')
              ->image()
              ->imageEditor()
              ->columnSpan('full'),

            Forms\Components\RichEditor::make('description')
              ->label('Description')
              ->validationAttribute('Description')
              ->placeholder('Description')
              ->toolbarButtons([
                'bold',
                'bulletList',
                'italic',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
              ])
              ->required()
              ->columnSpan('full'),
          ])
          ->searchPrompt('Search the Product by Name or Code Material')
          ->searchable(['name', 'code'])
          ->loadingMessage('Loading Products...')
          ->searchable()
          ->preload()
          ->required()
          ->columnSpan('full'),

        Forms\Components\DatePicker::make('date')
          ->label('Transaction Date')
          ->validationAttribute('Transaction Date')
          ->placeholder('Transaction Date')
          ->prefixIcon('heroicon-o-calendar')
          ->required()
          ->native(false)
          ->closeOnDateSelection()
          ->displayFormat('F j, Y'),

        Forms\Components\TextInput::make('amount')
          ->label('Amount')
          ->validationAttribute('Amount')
          ->placeholder('Amount')
          ->prefixIcon('heroicon-o-banknotes')
          ->required()
          ->numeric(),

        Forms\Components\Select::make('type')
          ->label('Transaction Type')
          ->validationAttribute('Transaction Type')
          ->placeholder('Transaction Type')
          ->options(TransactionType::class)
          ->required()
          ->live()
          ->columnSpan('full'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('created_at')
          ->label('Created At')
          ->dateTime()
          ->sortable()
          ->date('F j, Y')
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\TextColumn::make('updated_at')
          ->label('Updated At')
          ->dateTime()
          ->sortable()
          ->date('F j, Y')
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\TextColumn::make('product.code')
          ->label('Code Material')
          ->sortable(),

        Tables\Columns\TextColumn::make('product.name')
          ->label('Product Name')
          ->sortable(),

        Tables\Columns\TextColumn::make('date')
          ->label('Transaction Date')
          ->dateTime()
          ->sortable()
          ->date('F j, Y'),

        Tables\Columns\TextColumn::make('amount')
          ->label('Amount')
          ->numeric(),

        Tables\Columns\TextColumn::make('type')
          ->label('Type')
          ->badge()
          ->searchable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\ViewAction::make('view')
            ->label('View Transaction')
            ->icon(null),

          Tables\Actions\EditAction::make('edit')
            ->label('Edit Transaction')
            ->icon(null),

          Tables\Actions\DeleteAction::make('delete')
            ->label('Delete Transaction')
            ->color('danger')
            ->icon(null),
        ])
          ->size(\Filament\Support\Enums\ActionSize::Small)
          ->label('Action')
          ->color('gray')
          ->button()
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])

      ->recordAction(Tables\Actions\ViewAction::class)
      ->recordUrl(null);
  }

  public static function getRelations(): array
  {
    return [
      // 
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListTransactions::route('/'),
      'create' => Pages\CreateTransaction::route('/create'),
      'edit' => Pages\EditTransaction::route('/{record}/edit'),
    ];
  }
}
