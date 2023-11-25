<?php

namespace Jeffgreco13\FilamentWave\Models\Concerns;

use Jeffgreco13\Wave\Wave;
use Illuminate\Database\Eloquent\Model;
use function Illuminate\Events\queueable;

trait InteractsWithWaveCustomers {

    protected static function bootInteractsWithWaveCustomers(): void
    {
        static::creating(function (?Model $model) {
            // Create the Wave customer, then save the model.
            $wave = new Wave();
            $input = [
                "input" => [
                    'name' => $model->name,
                    'firstName' => $model->first_name,
                    'lastName' => $model->last_name,
                    'email' => $model->email,
                    'phone' => $model->phone,
                ]
            ];
            $response = $wave->customerCreate($input);
            if ($id = data_get($response, 'data.customerCreate.customer.id', null)) {
                $model->id = $id;
            } else {
                return false;
            }
        });

        static::updating(function (?Model $model) {
            $wave = new Wave();
            $input = [
                "input" => [
                    'id' => $model->id,
                    'name' => $model->name,
                    'firstName' => $model->first_name,
                    'lastName' => $model->last_name,
                    'email' => $model->email,
                    'phone' => $model->phone
                ]
            ];
            $response = $wave->customerPatch($input);
            if (!$wave->didSucceed()){
                return false;
            }
        });

        static::deleting(function (?Model $model) {
            $wave = new Wave();
            $input = [
                "input" => [
                    'id' => $model->id,
                ]
            ];
            $response = $wave->customerDelete($input);
            if (!$wave->didSucceed()) {
                return false;
            }
        });
    }

}
