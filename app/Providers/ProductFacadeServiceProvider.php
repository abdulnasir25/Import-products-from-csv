<?php

namespace App\Providers;

use App\Facades\ProductFacade;
use Illuminate\Support\ServiceProvider;

class ProductFacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('product-importer-facade', function() {
            return new ProductFacade();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
