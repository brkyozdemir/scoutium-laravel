<?php

namespace App\Providers;

use App\Mail\IMailgunRepository;
use App\Mail\IMailgunService;
use App\Mail\MailgunRepository;
use App\Mail\MailgunService;
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
        app()->bind(IMailgunService::class, MailgunService::class);
        app()->bind(IMailgunRepository::class, MailgunRepository::class);
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
