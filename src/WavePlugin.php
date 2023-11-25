<?php

namespace Jeffgreco13\FilamentWave;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Jeffgreco13\FilamentWave\Models\Product;
use Jeffgreco13\FilamentWave\Models\Customer;
use Jeffgreco13\FilamentWave\Filament\Resources\ProductResource;
use Jeffgreco13\FilamentWave\Filament\Resources\CustomerResource;

class WavePlugin implements Plugin
{
    protected bool $hasCustomers = false;
    protected $customerResource;
    protected $customerModel;
    protected bool $hasProducts = false;
    protected $productResource;
    protected $productModel;


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

        if ($this->hasCustomers && !is_null($this->getCustomerResource())){
            $registeredResources[] = $this->getCustomerResource();
        }

        if ($this->hasProducts && !is_null($this->getProductResource())) {
            $registeredResources[] = $this->getProductResource();
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

    /*
     *
     * CUSTOMERS
     *
     */
    public function customers(
        bool $condition = true,
        ?string $resource = CustomerResource::class,
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

    /*
     *
     * PRODUCTS
     *
     */
    public function products(
        bool $condition = true,
        ?string $resource = ProductResource::class,
        string $model = Product::class
    ): static {
        $this->hasProducts = $condition;
        $this->productResource = $resource;
        $this->productModel = $model;
        return $this;
    }
    public function hasProducts(): bool
    {
        return $this->hasProducts;
    }
    public function getProductResource()
    {
        return $this->productResource;
    }
    public function getProductModel()
    {
        return $this->productModel;
    }
}
