<?php

namespace App\Providers;

use App\Services\PostCodesIODataService;
use Illuminate\Support\ServiceProvider;

class PostCodeIOServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('PostCodesIO', function ($app, $parameters) {
            return new PostCodesIODataService($parameters['postcodes_service']);
        });
    }
}
