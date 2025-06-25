<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TrackingTrafficSource;
use Illuminate\Support\Facades\DB;

class TrackTrafficSource
{
    public function handle(Request $request, Closure $next)
    {
        $referrer = $request->headers->get('referer');
        $source = null;

        if ($referrer) {
            $host = strtolower(parse_url($referrer, PHP_URL_HOST));

            switch (true) {
                case str_contains($host, 'facebook'):
                    $source = 'Facebook';
                    break;
                case str_contains($host, 'twitter'):
                case str_contains($host, 'x.com'):
                    $source = 'Twitter';
                    break;
                case str_contains($host, 'instagram'):
                    $source = 'Instagram';
                    break;
                case str_contains($host, 'linkedin'):
                    $source = 'Linkedin';
                    break;
                case str_contains($host, 'youtube'):
                    $source = 'YouTube';
                    break;
            }
        }

        // Fallback to query parameter if referer not found or not matched
        if (!$source && $request->has('source')) {
            $source = ucfirst(strtolower($request->get('source')));
        }

        if ($source) {
            TrackingTrafficSource::updateOrCreate(
                ['source' => $source],
                ['count' => DB::raw('count + 1')]
            );
        }

        return $next($request);
    }
}
