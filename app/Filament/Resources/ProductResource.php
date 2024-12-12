<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\TransactionsRelationManager;

class ProductResource extends Resource
{
  protected static ?string $model = Product::class;
  protected static ?string $navigationGroup = 'Product Management';
  protected static ?string $navigationIcon = 'heroicon-o-archive-box';
  protected static ?int $navigationSort = 1;

  public static function getModelLabel(): string
  {
    return __('Products');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
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

        Forms\Components\TextInput::make('incoming')
          ->label('Total Incoming')
          ->validationAttribute('Total Incoming')
          ->placeholder('Total Incoming')
          ->prefixIcon('heroicon-o-archive-box-arrow-down')
          ->disabled()
          ->numeric()
          ->default(0),

        Forms\Components\TextInput::make('reserved')
          ->label('Total Reserved')
          ->validationAttribute('Total Reserved')
          ->placeholder('Total Reserved')
          ->prefixIcon('heroicon-o-archive-box-x-mark')
          ->disabled()
          ->numeric()
          ->default(0),

        Forms\Components\TextInput::make('balance')
          ->label('Initial Balance')
          ->validationAttribute('Initial Balance')
          ->placeholder('Initial Balance')
          ->prefixIcon('heroicon-o-archive-box')
          ->columnSpan('full')
          ->disabled()
          ->numeric()
          ->default(0),

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

        Tables\Columns\TextColumn::make('code')
          ->label('Code Material')
          ->searchable(),

        Tables\Columns\ImageColumn::make('image')
          ->label('Image')
          ->square()
          ->size(40)
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\TextColumn::make('name')
          ->label('Name')
          ->searchable(),

        Tables\Columns\TextColumn::make('unit_of_measure')
          ->label('Unit of Measure')
          ->badge()
          ->searchable(),

        Tables\Columns\TextColumn::make('incoming')
          ->label('Incoming')
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('reserved')
          ->label('Reserved')
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('balance')
          ->label('Balance')
          ->numeric()
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\ViewAction::make('view')
            ->label('View Product')
            ->icon(null),

          Tables\Actions\EditAction::make('edit')
            ->label('Edit Product')
            ->icon(null),

          Tables\Actions\DeleteAction::make('delete')
            ->label('Delete Product')
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
      ->recordAction(Tables\Actions\ViewAction::class);
  }

  public static function getRelations(): array
  {
    return [
      TransactionsRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListProducts::route('/'),
      'create' => Pages\CreateProduct::route('/create'),
      'view' => Pages\ViewProduct::route('/{record}'),
      'edit' => Pages\EditProduct::route('/{record}/edit'),
    ];
  }
}
