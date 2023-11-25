<?php

namespace Jeffgreco13\FilamentWave\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait CanBeArchived {
    public function scopeActive(Builder $query): void
    {
        $query->where('is_archived', false);
    }
    public function scopeArchived(Builder $query): void
    {
        $query->where('is_archived', true);
    }
    public function archive()
    {
        $this->is_archived = true;
        $this->saveQuietly();
    }

    public function unarchive()
    {
        $this->is_archived = false;
        $this->saveQuietly();
    }

    public function toggleArchive()
    {
        if ($this->is_archived) {
            $this->unarchive();
        } else {
            $this->archive();
        }
    }
}
