<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use App\Enums\TransactionType;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Product;

class ReservationResource extends Resource
{
  protected static ?string $model = Transaction::class;
  protected static ?string $navigationGroup = 'Transaction Management';
  protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
  protected static ?int $navigationSort = 3;

  public static function getModelLabel(): string
  {
    return __('Reservation');
  }

  public static function getEloquentQuery(): Builder
  {
    return Transaction::query()->where('type', TransactionType::Reserved);
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
          ->required()
          ->preload()
          ->live()
          ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
            $product = Product::find($state);
            $balance = $product->balance;

            return $set('balance', $balance);
          }),

        Forms\Components\TextInput::make('balance')
          ->label('Current Balance')
          ->validationAttribute('Current Balance')
          ->placeholder('Balance')
          ->prefixIcon('heroicon-o-archive-box')
          ->disabled()
          ->numeric()
          ->default(0),

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
          ->prefixIcon('heroicon-o-archive-box')
          ->required()
          ->numeric()
          ->gte(0)
          ->lte(function (Forms\Get $get) {
            $product = Product::find($get('product_id'));
            $balance = $product->balance;
            return $balance;
          }, true),

        Forms\Components\TextInput::make('type')
          ->label('Transaction Type')
          ->validationAttribute('Transaction Type')
          ->placeholder('Transaction Type')
          ->default(TransactionType::Reserved)
          ->required()
          ->readonly()
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

        Tables\Columns\TextColumn::make('type')
          ->label('Type')
          ->badge()
          ->searchable(),

        Tables\Columns\TextColumn::make('date')
          ->label('Transaction Date')
          ->dateTime()
          ->sortable()
          ->date('F j, Y'),

        Tables\Columns\TextColumn::make('amount')
          ->label('Amount')
          ->numeric()
          ->sortable(),

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
          ->icon(null)
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
      'index' => Pages\ListReservations::route('/'),
      'create' => Pages\CreateReservation::route('/create'),
      'edit' => Pages\EditReservation::route('/{record}/edit'),
    ];
  }
}
