<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->session()->has('username') && $request->session()->has('password')){
            $username = $request->session()->get('username');
            $password =  $request->session()->get('password');
            $cek = DB::table('user')
                        ->whereRaw("id_user = AES_ENCRYPT('{$username}', 'nur')")
                        ->whereRaw("password = AES_ENCRYPT('{$password}', 'windi')")
                        ->first();
            if($cek){
                return redirect('/dashboard');
            }else{
                return $next($request);
            }    
        }
        return $next($request);
    }
}
