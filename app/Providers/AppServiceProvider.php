<?php

namespace App\Providers;

use App\Mailer\CarobMailer;
use App\Mailer\MailProviderInterface;
use App\Mailer\SmtpMailer;
use Exception;
use Illuminate\Foundation\Application;
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
        $this->app->singleton(MailProviderInterface::class, function (Application $app) {
            return match (env('MAIL_PROVIDER')) {
                'smtp' => new SmtpMailer(),
                'carob-mailer' => new CarobMailer(),
                default => throw new Exception('No mail provider'),
            };
        });
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
