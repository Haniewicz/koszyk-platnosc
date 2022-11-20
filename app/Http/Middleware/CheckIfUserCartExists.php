<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckIfUserCartExists
{

    public function handle(Request $request, Closure $next)
    {
        if($request->user()->cart === null){
            $cart = new Cart();
            $cart->token = Str::random(32);
            $cart->user_id = $request->user()->id;
            $cart->save();

            $request->user()->cart = $cart;
        }

        return $next($request);
    }
}
