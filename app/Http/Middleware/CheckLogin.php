<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = User::getUid();
        if (empty($id)) {
            return redirect('/login');
        }
        return $next($request);
    }
}
