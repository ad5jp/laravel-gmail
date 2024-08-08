<?php

namespace AD5jp\LaravelGmail;

use AD5jp\LaravelGmail\GmailTransport;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/gmail.php', 'gmail'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app('swift.transport')->extend('gmail', static function ($app) {
            return $app->make(GmailTransport::class);
        });
    }
}
