<?php

namespace Jeffgreco13\FilamentWave\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Jeffgreco13\FilamentWave\Filament\Actions\ArchiveTableAction;
use Jeffgreco13\FilamentWave\Filament\Resources\CustomerResource\Pages;
use Jeffgreco13\FilamentWave\Filament\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static string $modalWidth = "lg";

    public static function getModel(): string
    {
        return filament('wave')->getCustomerModel();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Customer or Business Name')
                    ->placeholder('Dunder Mifflin')
                    ->default('AAA Test')
                    ->required(),
                Forms\Components\Fieldset::make('Primary contact')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('first_name')
                        ->default('Mike')
                        ->placeholder('Michael'),
                    Forms\Components\TextInput::make('last_name')
                        ->default('Jones')
                        ->placeholder('Scott'),
                    Forms\Components\TextInput::make('email')
                        ->default('mike.jones@gmail.com')
                        ->placeholder('mscott@dundermifflin.com')
                        ->email(),
                    Forms\Components\TextInput::make('phone')
                        ->default('705-255-1775'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(['name', 'first_name', 'last_name'])
                    ->weight(FontWeight::Bold)
                    ->sortable()
                    ->description(fn ($record) => $record->name != $record->full_name ? $record->full_name : null),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth(self::$modalWidth),
                Tables\Actions\ActionGroup::make([
                    ArchiveTableAction::make('archive'),
                    Tables\Actions\DeleteAction::make()
                        ->form([
                            Forms\Components\Toggle::make('deleteWave')
                                ->label('Attempt to delete this record in Wave as well.')
                                ->onColor('success')
                                ->onIcon('heroicon-m-check')
                                ->default(false)
                        ])
                        ->using(function($data,$record){
                            if (!data_get($data,'deleteWave',false)){
                                $record->deleteQuietly();
                            } else {
                                $record->delete();
                            }
                            Notification::make()->success()->title('Deleted')->send();
                        })

                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }
}
