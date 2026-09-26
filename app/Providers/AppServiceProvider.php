<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{

        if ($codespaceName = env('CODESPACE_NAME')) {
            $domain = env('GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN', 'app.github.dev');
            $url = "https://{$codespaceName}-8000.{$domain}";

            \Illuminate\Support\Facades\URL::forceRootUrl($url);
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
}
}
