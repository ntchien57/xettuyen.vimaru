<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        Log::info('MIDDLEWARE INPUT', ['raw_roles' => $role]); // LOG NGAY ĐẦU TIÊN

        $allowedRoles = array_map('intval', explode(',', $role));
        $userRole = (int) Auth::user()->role;

        Log::info('ROLE CHECK', [
            'expected_roles' => $allowedRoles,
            'actual_user_role' => $userRole,
            'type' => gettype($userRole)
        ]);

        foreach ($allowedRoles as $r) {
            if ($r == $userRole) {
                return $next($request);
            }
        }

        return redirect()->back()->with('error', 'Bạn không có quyền truy cập.');
    }
}
