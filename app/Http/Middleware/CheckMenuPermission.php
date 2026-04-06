<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\PermissionHelper;

class CheckMenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string $requiredMenuKey Menu key yang dibutuhkan untuk akses route ini
     */
    public function handle(Request $request, Closure $next, string $requiredMenuKey): Response
    {
        // Jika user tidak login, redirect ke login
        if (!session('id_user')) {
            return redirect('/login');
        }

        // Jika user tidak memiliki permission untuk menu ini
        if (!PermissionHelper::hasPermission($requiredMenuKey)) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini karena menu sudah dinonaktifkan oleh superadmin.');
        }

        return $next($request);
    }
}
