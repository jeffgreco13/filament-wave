<?php

namespace Jeffgreco13\FilamentWave\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use Jeffgreco13\Wave\Wave;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Jeffgreco13\FilamentWave\Jobs\PullWaveProducts;
use Jeffgreco13\FilamentWave\Filament\Resources\ProductResource;

class ManageProducts extends ManageRecords
{
    public static function getResource(): string
    {
        return filament('wave')->getProductResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ActionGroup::make([
                Actions\Action::make('pull')
                    ->label('Pull from Wave')
                    ->icon('heroicon-o-arrow-down-circle')
                    ->requiresConfirmation()
                    ->modalDescription("This will pull all products immediately. Do you want to continue?")
                    ->action(function () {
                        PullWaveProducts::dispatchSync();
                        Notification::make()->success()->title('Products pulled successfully.')->send();
                    })
                ])
        ];
    }

    public function getTabs(): array
    {
        return [
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->active()),
            'archived' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->archived()),
        ];
    }
}
