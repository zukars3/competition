<?php

namespace App\Providers;

use App\CompetitionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('CompetitionService', function () {
            return new CompetitionService();
        });
    }

    public function boot()
    {
        //
    }
}
