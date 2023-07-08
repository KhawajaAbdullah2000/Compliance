<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {

              if(Auth::user()->privilege_id!=4){
                //he is rot user
                    return $next($request);

              }   
              else{
                return redirect()->route('root_home')->with('error','Access Denied');

              }

        }else{
            return redirect()->route('home')->with('error','Please Login to access');


        }
    }
}
