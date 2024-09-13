<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDownloadRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lastDownloadTime = session('last_download_time');
        
        $timeLimit = 5; // seconds
        $currentTime = now()->timestamp;
        // If the user has downloaded an image recently
        if ($lastDownloadTime && ($currentTime - $lastDownloadTime) < $timeLimit) {
            return response()->json(['message' => 'Please wait before downloading another image.'], 429);
        }

        return $next($request);

    }
}
