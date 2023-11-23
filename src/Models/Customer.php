<?php

namespace Jeffgreco13\FilamentWave\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Customer extends Model
{
    use Concerns\InteractsWithWaveCustomers;
    protected $table = 'wave_customers';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'meta' => AsArrayObject::class,
        'address' => AsArrayObject::class,
        'currency' => AsArrayObject::class
    ];

    public $incrementing = false;

    /*
     *
     * QUERY SCOPES
     *
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_archived', false);
    }
    public function scopeArchived(Builder $query): void
    {
        $query->where('is_archived', true);
    }

    /*
     *
     * ATTRIBUTES
     *
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name'],
        );
    }

    /*
     *
     * METHODS/ACTIONS
     *
     */
    public function archive()
    {
        $this->update(['is_archived' => true]);
    }

    public function unarchive()
    {
        $this->update(['is_archived' => false]);
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
