<?php

namespace Jeffgreco13\FilamentWave;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Jeffgreco13\FilamentWave\Models\Customer;
use Jeffgreco13\FilamentWave\Filament\Resources\CustomerResource;

class WavePlugin implements Plugin
{
    protected bool $hasCustomers = false;
    protected $customerResource;
    protected $customerModel;


    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'wave';
    }

    public function register(Panel $panel): void
    {
        $registeredResources = [];
        $registeredPages = [];

        if ($this->hasCustomers){
            $registeredResources[] = $this->getCustomerResource();
        }

        if (!empty($registeredResources)){
            $panel->resources($registeredResources);
        }
        if (!empty($registeredPages)) {
            $panel->pages($registeredPages);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function customers(
        bool $condition = true,
        string $resource = CustomerResource::class,
        string $model = Customer::class
    ): static
    {
        $this->hasCustomers = $condition;
        $this->customerResource = $resource;
        $this->customerModel = $model;
        return $this;
    }
    public function hasCustomers(): bool
    {
        return $this->hasCustomers;
    }
    public function getCustomerResource()
    {
        return $this->customerResource;
    }
    public function getCustomerModel()
    {
        return $this->customerModel;
    }
}
