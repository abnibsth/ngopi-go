<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
     * Handles URL generation when accessed through tunnels (ngrok, localtunnel, etc.)
     * so that asset (CSS/JS) URLs use the correct public domain instead of localhost.
     */
    public function boot(): void
    {
        // Detect if the request is coming through a reverse proxy / tunnel (ngrok, etc.)
        $forwardedProto = request()->header('X-Forwarded-Proto');
        $forwardedHost  = request()->header('X-Forwarded-Host');

        if ($forwardedProto === 'https' && $forwardedHost) {
            // Force the full root URL so asset() and @vite() produce correct HTTPS + domain URLs
            URL::forceRootUrl('https://' . $forwardedHost);
            URL::forceScheme('https');
        } elseif ($forwardedProto === 'https') {
            URL::forceScheme('https');
        }
    }
}
