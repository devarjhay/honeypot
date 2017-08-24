<?php

namespace DevArjhay\Honeypot\Providers;

use DevArjhay\Honeypot\Honeypot;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class HoneypotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishing Config
        $this->publishes([
            __DIR__ . '/../config' => config_path()
        ], 'config');

        // Publishing Translations
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/honeypot')
        ], 'lang');

        // Merge Config
        $this->mergeConfigFrom(__DIR__ . '/../config/honeypot.php', 'honeypot');

        // Load translations.
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'honeypot');

        $this->app->booted(function ($app) {
            // Get the validation and translator
            $validator = $app['validator'];
            $translator = $app['translator'];

            // Add honeypot and honey time custom validation rules.
            $validator->extend('honeypot', 'honeypot@validateHoneypot', $translator->get('honeypot::validation.honeypot'));
            $validator->extend('honeytime', 'honeypot@validateHoneytime', $translator->get('honeypot::validation.honeytime'));
        });

        Blade::directive('honeypot', function ($expression) {
            list($name, $time) = explode(', ', str_replace(['(',')'], '', $expression));
            return \DevArjhay\Honeypot\Facades\Honeypot::make(trim($name, "'"), trim($time, "'"));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('honeypot', function () {
            return new Honeypot;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['honeypot'];
    }
}
