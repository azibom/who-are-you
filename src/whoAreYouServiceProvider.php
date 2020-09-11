<?php

namespace Azibom\whoAreYou;

use Azibom\whoAreYou\Contracts\User\UserRepositoryInterface;
use Azibom\whoAreYou\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class WhoAreYouServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::routes();
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
    }
}
