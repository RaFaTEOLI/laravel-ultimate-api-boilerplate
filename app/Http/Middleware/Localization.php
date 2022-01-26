<?php

namespace App\Http\Middleware;

use App\Http\HttpStatus;
use App\Traits\ApiResponser;
use Closure;
use Illuminate\Support\Facades\App;

class Localization
{
    use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->header('Content-Language');

        if (!$locale) {
            $locale = App::getLocale();
        }

        if ($locale != 'en' && $locale != 'pt-BR') {
            return $this->error(__('generic.invalidLocalization', ['locale' => $locale]), HttpStatus::BAD_REQUEST);
        }

        App::setLocale($locale);

        $response = $next($request);
        $response->headers->set('Content-Language', $locale);


        return $response;
    }
}
