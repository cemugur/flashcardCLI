<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\FlashCardRepositoryInterface;
use App\Repositories\FlashCardRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserAnswerRepositoryInterface;
use App\Repositories\UserAnswerRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FlashCardRepositoryInterface::class, FlashCardRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserAnswerRepositoryInterface::class, UserAnswerRepository::class);
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
