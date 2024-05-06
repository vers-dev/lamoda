<?php

namespace App\Providers;

use App\Contracts\Product\ProductRepositoryContract;
use App\Contracts\Product\ProductServiceContract;
use App\Contracts\Reserve\ReserveProductServiceContract;
use App\Contracts\Reserve\ReserveRepositoryContract;
use App\Contracts\Reserve\ReserveServiceContract;
use App\Contracts\StorageProduct\StorageProductRepositoryContract;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Reserve\ReserveRepository;
use App\Repositories\StorageProduct\StorageProductRepository;
use App\Services\Product\ProductService;
use App\Services\Reserve\ReserveProductService;
use App\Services\Reserve\ReserveService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: ReserveRepositoryContract::class, concrete: ReserveRepository::class);
        $this->app->bind(abstract: ProductRepositoryContract::class, concrete: ProductRepository::class);
        $this->app->bind(abstract: ProductServiceContract::class, concrete: ProductService::class);
        $this->app->bind(abstract: ReserveProductServiceContract::class, concrete: ReserveProductService::class);
        $this->app->bind(abstract: ReserveServiceContract::class, concrete: ReserveService::class);
        $this->app->bind(abstract: StorageProductRepositoryContract::class, concrete: StorageProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
