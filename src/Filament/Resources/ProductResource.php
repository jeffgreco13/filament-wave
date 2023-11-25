<?php

namespace Jeffgreco13\FilamentWave\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Jeffgreco13\FilamentWave\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Jeffgreco13\FilamentWave\Filament\Actions\ArchiveTableAction;
use Jeffgreco13\FilamentWave\Filament\Resources\ProductResource\Pages;
use Jeffgreco13\FilamentWave\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static string $modalWidth = "lg";

    public static function getModel(): string
    {
        return filament('wave')->getProductModel();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Product name')
                    ->placeholder('Computer Repair')
                    ->default('Computers')
                    ->required(),
                Forms\Components\TextInput::make('unit_price')
                    ->placeholder('2.065')
                    ->default('1.567')
                    ->numeric()
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->default('test descriptuon')
                    ->placeholder('Computer repair and virus removal service. Includes 1 computer.')
                    ->columnSpanFull(),
                Forms\Components\Placeholder::make('Account')
                    ->content(fn($record) => $record->account_name),
                Forms\Components\Placeholder::make('Type')
                    ->content(fn ($record) => $record->product_type),
                Forms\Components\Placeholder::make('notice')
                    ->hiddenLabel()
                    ->content(new HtmlString("<i>Edit the Account and Product Type in Wave, then resync.</i>"))
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(['name', 'description'])
                    ->weight(FontWeight::Bold)
                    ->sortable()
                    ->description(fn ($record) => str($record->description)->limit(50)),
                Tables\Columns\TextColumn::make('unit_price'),
                Tables\Columns\TextColumn::make('product_type')
                    ->description(fn($record) => $record->account_name)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth(self::$modalWidth),
                ArchiveTableAction::make('archive')
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }
}
