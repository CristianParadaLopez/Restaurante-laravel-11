<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Accepts roles as separate args or as comma-separated values.
     *
     * @param Request $request
     * @param Closure $next
     * @param mixed ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'No tienes permiso para acceder a esta página. (no-auth)');
        }

        // Normalizar roles: puede venir como ['admin,chef,mesero'] o como ['admin','chef']
        $normalized = collect($roles)
            ->flatMap(function ($r) {
                // si viene null o vacío, devolver []
                if (is_null($r) || $r === '') {
                    return [];
                }
                // explode si viene con comas
                return array_map('trim', explode(',', $r));
            })
            ->filter()
            ->unique()
            ->values()
            ->all();

        // Opcional: debug temporal (comentar en producción)
        // Log::debug('RoleMiddleware: user_id='.$user->id.' roles_passed='.json_encode($normalized).' user_roles='.json_encode(method_exists($user,'getRoleNames') ? $user->getRoleNames() : $user->usertype));

        // Si Spatie está disponible, usar sus helpers
        if (method_exists($user, 'hasAnyRole')) {
            if ($user->hasAnyRole($normalized)) {
                return $next($request);
            }
        } else {
            // fallback a usertype string
            if (in_array($user->usertype, $normalized, true)) {
                return $next($request);
            }
        }

        abort(403, 'No tienes permiso para acceder a esta página. (sin-rol)');
    }
}
