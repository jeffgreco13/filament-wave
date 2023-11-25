<?php

namespace Jeffgreco13\FilamentWave\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use Concerns\CanBeArchived, Concerns\InteractsWithWaveProducts;

    public $incrementing = false;

    protected $table = 'wave_products';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'taxes' => 'array',
        'account' => 'array'
    ];

    /*
     *
     * ATTRIBUTES
     *
     */
    protected function productType(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value,array $attributes) => match (true) {
                (bool) $attributes['is_sold'] => 'Income',
                (bool) $attributes['is_bought'] => 'Expense',
                default => 'Error'
            },
        );
    }

    protected function accountName(): Attribute
    {
        return Attribute::make(
            get: fn () => data_get($this, 'account.name', null),
        );
    }

}
