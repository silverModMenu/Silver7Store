<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }

        $user = auth()->user();

        // Super Admin tem acesso a tudo
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Verificar se o usuário tem todas as permissões requeridas
        if (!$user->hasAnyPermission($permissions)) {
            abort(403, 'Você não tem permissão para acessar este recurso.');
        }

        return $next($request);
    }
}
