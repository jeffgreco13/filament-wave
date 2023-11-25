<?php

namespace Jeffgreco13\FilamentWave\Models\Concerns;

use Jeffgreco13\Wave\Wave;
use Illuminate\Database\Eloquent\Model;
use function Illuminate\Events\queueable;

trait InteractsWithWaveProducts {

    protected static function bootInteractsWithWaveProducts(): void
    {
        static::updating(function (?Model $model) {
            $wave = new Wave();
            $input = [
                "input" => [
                    'id' => $model->id,
                    'name' => $model->name,
                    'description' => $model->description,
                    'unitPrice' => $model->unit_price
                ]
            ];

            $response = $wave->productPatch($input);
            // WIP: Can I do anything to alert of a failure?
        });
    }

}
