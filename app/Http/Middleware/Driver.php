<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

class Driver extends Authenticate
{
    protected function redirectTo($request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
