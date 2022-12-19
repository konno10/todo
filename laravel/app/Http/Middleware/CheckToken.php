<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\UserService;

class CheckToken
{
    /**
     * 送信されてきたリクエストの処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      $loginInfo = (new UserService())->getLoginInfoByToken($request->header('token'));
      if(!$loginInfo){
          return response()->json(['errorMessage' => 'このトークンは有効ではありません'], 401);
      }
      return $next($request);
    }
}
