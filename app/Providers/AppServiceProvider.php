<?php

namespace App\Providers;

use App\Models\Broadcast;
use App\Models\Macros\HasManySync;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        new HasManySync();

        Relation::morphMap([
            'broadcast' => Broadcast::class
        ]);

        Http::macro('withAuth', function () {
            return Http::baseUrl(config('services.kfit.urls.auth'))
                ->acceptJson()
                ->withToken(\request()?->bearerToken());
        });
    }
}
