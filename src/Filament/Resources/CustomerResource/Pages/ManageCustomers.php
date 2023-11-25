<?php

namespace Jeffgreco13\FilamentWave\Filament\Resources\CustomerResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ManageRecords;
use Jeffgreco13\FilamentWave\Jobs\PullWaveCustomers;

class ManageCustomers extends ManageRecords
{
    public static function getResource(): string
    {
        return filament('wave')->getCustomerResource();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->modalWidth(self::getResource()::$modalWidth),
            Actions\ActionGroup::make([
                Actions\Action::make('pull')
                    ->label('Pull from Wave')
                    ->icon('heroicon-o-arrow-down-circle')
                    ->requiresConfirmation()
                    ->modalDescription("This will pull all customers immediately. Do you want to continue?")
                    ->action(function(){
                        PullWaveCustomers::dispatchSync();
                        Notification::make()->success()->title('Customers pulled successfully.')->send();
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
