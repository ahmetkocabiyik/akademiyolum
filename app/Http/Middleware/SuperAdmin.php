<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

/**
 * Yönetim paneli kapısı. Yetkisi olmayana 403 değil 404: panelin varlığı
 * bile belli olmasın.
 */
class SuperAdmin
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(Gate::allows('super-admin'), 404);

        return $next($request);
    }
}
