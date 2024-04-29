<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

abstract class Controller
{
    public function handle($request, Closure $next)
    {
        $lang = Session::get('locale', 'en');
        App::setLocale($lang);

        return $next($request);
    }
}
