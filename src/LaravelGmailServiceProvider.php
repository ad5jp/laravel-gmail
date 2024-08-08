<?php

namespace AD5jp\LaravelGmail;

use AD5jp\LaravelGmail\GmailTransport;
use Illuminate\Support\ServiceProvider;

class LaravelGmailServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/gmail.php', 'mail.mailers.gmail'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app('mail.manager')->extend('gmail', static function ($config) {
            return new GmailTransport($config);
        });
    }
}