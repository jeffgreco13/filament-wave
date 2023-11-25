<?php

namespace Jeffgreco13\FilamentWave\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Customer extends Model
{
    use Concerns\CanBeArchived, Concerns\InteractsWithWaveCustomers;
    public $incrementing = false;

    protected $table = 'wave_customers';

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $casts = [
        'meta' => AsArrayObject::class,
        'address' => AsArrayObject::class,
        'currency' => AsArrayObject::class
    ];

    /*
     *
     * QUERY SCOPES
     *
     */


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



}
