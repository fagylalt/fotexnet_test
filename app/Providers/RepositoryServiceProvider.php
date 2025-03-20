<?php

namespace App\Providers;

use App\Interfaces\IRepository;
use App\Repositories\MovieRepository;
use App\Repositories\ScreeningRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            IRepository::class,
            MovieRepository::class
        );

        $this->app->bind(
            IRepository::class,
            ScreeningRepository::class
        );

    }
}
