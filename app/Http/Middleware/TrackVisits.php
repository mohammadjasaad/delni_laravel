<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;

class TrackVisits
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $path = $request->path();

            // ✅ تجاهل لوحات التحكم فقط
            if (!str_starts_with($path, 'admin') && !str_starts_with($path, 'dashboard')) {
                Visitor::create([
                    'ip'         => $request->ip(),
                    'page'       => $path,
                    'user_agent' => $request->header('User-Agent'),
                    'visited_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("TrackVisits error: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }

        return $next($request);
    }
}
