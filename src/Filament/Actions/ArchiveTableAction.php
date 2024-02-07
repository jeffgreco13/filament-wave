<?php

namespace Jeffgreco13\FilamentWave\Filament\Actions;

use Filament\Tables\Actions\Action;

class ArchiveTableAction extends Action
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'archive')
            ->label(fn ($record) => $record->is_archived ? 'Restore' : 'Archive')
            ->color('warning')
            ->icon('heroicon-s-archive-box')
            ->action(function ($record) {
                $record->toggleArchive();
            });

    }
}
